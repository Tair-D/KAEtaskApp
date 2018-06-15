<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\Response;
use \Laravel\Passport\Http\Controllers\AccessTokenController as ATC;
class AccessTokenController extends ATC
{
    public function issueToken(ServerRequestInterface $request)
    {
        DB::beginTransaction();

        try {
            //get username (default is :email)
            $username = $request->getParsedBody()['username'];

            //get user
            $user = User::where('email', '=', $username)->first();

            if (!$user) {
                throw new ModelNotFoundException();
            }

            DB::table('oauth_access_tokens')
                ->where('user_id', '=', $user->id)
                ->update(['revoked' => true]);

            //generate token
            $tokenResponse = parent::issueToken($request);

            //convert response to json string
            $content = $tokenResponse->getContent();

            //convert json to array
            $data = json_decode($content, true);

            if(isset($data["error"]))
                throw new OAuthServerException('The user credentials were incorrect.', 6, 'invalid_credentials', 401);

            //add access token to user
            $user = collect($user);
            $user->put('access_token', $data['access_token']);

            DB::commit();

            return response()->json($user);
        }
        catch (ModelNotFoundException $e) { // email notfound
            DB::rollback();
            return response(["message" => "User not found"], 400);
        }
        catch (OAuthServerException $e) { //password not correct..token not granted
            DB::rollback();
            return response(["message" => "The user credentials were incorrect.', 6, 'invalid_credentials"], 400);
    }
        catch (Exception $e) {
            DB::rollback();
            return response(["message" => "Internal server error"], 400);
        }
    }
}

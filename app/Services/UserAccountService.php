<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class UserAccountService
{

    public function getUserAccountByEmail($email)
    {

        try {
            // ****** part 1 *******//

            //check that the any user is existing in login.baaboo with this email 
            if (User::where('email', $email)->exists()) {
                return response()->json([
                    'success' => true,
                    "customer" => User::where('email', $email)->first(),
                    "message" => "UserAccount found in local DB"
                ]);
            }
            $url = env("APP_LOGIN_URL", 'https://login.baaboo.com') . "/api/get-user-by-email";
            //making http request to the login.baaboo api with custom TOKEN in header and data in body
            $response = Http::withoutVerifying()->withHeaders([
                'Token' =>  env('APP_LOGIN_TOKEN')
            ])->get($url, [
                'email' => $email
            ]);


            // Check if the request was successful
            if ($response->successful()) {
                $data = $response->json(); // Decode JSON response to array


                $customerData = $data['user'] ?? null;
                if ($customerData) {
                    if (isset($customerData['id'])) {
                        $customer = [
                            'id' => $customerData['id'],
                            'name' => $customerData['name'] ?? $customerData["profile"]['first_name'] . ' ' . $customerData["profile"]['last_name'] ?? "",

                            'first_name' => $customerData["profile"]['first_name'] ?? "",
                            'last_name' => $customerData["profile"]['last_name'] ?? "",
                            'address' => $customerData["profile"]['address'] ?? "",
                            'postal_code' => $customerData["profile"]['postal_code'] ?? "",
                            'city' => $customerData["profile"]['city'] ?? "",
                            'country' => $customerData["profile"]['country'] ?? "",
                            'email' => $customerData['email'] ?? "",
                            'bio' => $customerData["profile"]['bio'] ?? "",
                            'avatar' => $customerData["profile"]['avatar'] ?? "",
                            'linkedin' => $customerData["profile"]['linkedin'] ?? "",
                            'instagram' => $customerData["profile"]['instagram'] ?? "",
                            'twitter' => $customerData["profile"]['twitter'] ?? "",
                            'phone' => $customerData["profile"]['phone'] ?? null
                        ];

                        User::insert([
                            'id' => $customer['id'],
                            'name' => $customer['name'],
                            'email' => $customer['email'],
                            'password' => bcrypt(time())
                        ]);
                    } else {
                        $customer = [

                            'email' => $customerData['email'] ?? "",

                        ];
                    }
                    return response()->json([
                        'success' => true,
                        "customer" => $customer,
                        "message" => "UserAccount found in login.baaboo"
                    ]);
                }
            }
        } catch (Exception $e) {
            return response([
                "success" => false,
                "message" => $e->getMessage(),
                'code' => 500,
                'line' => $e->getLine(),

            ], 500);
        }
    }




    public function getUserAccountById($id)
    {
        try {

            // ****** part 1 *******//
            //check that the any user is existing in login.baaboo with this email 
            $url = env("APP_LOGIN_URL", 'https://login.baaboo.com') . "/api/profile";
            //making http request to the login.baaboo api with custom TOKEN in header and data in body
            $response = Http::withoutVerifying()->withHeaders([
                'Token' =>  env('APP_LOGIN_TOKEN')
            ])->get($url, [
                'user_id' => $id
            ]);
            // Check if the request was successful
            if ($response->successful()) {
                $data = $response->json(); // Decode JSON response to array

                $customerData = $data['user'] ?? null;
                if (!$customerData) {
                    return response()->json([
                        'success' => false,
                        'message' => 'UserAccount not found.'
                    ], 404);
                }
                $customer = [
                    'id' => $customerData['id'],
                    'name' => $customerData['name'] ?? $customerData["profile"]['first_name'] . ' ' . $customerData["profile"]['last_name'] ?? "",
                    'first_name' => $customerData["profile"]['first_name'] ?? "",
                    'last_name' => $customerData["profile"]['last_name'] ?? "",
                    'address' => $customerData["profile"]['address'] ?? "",
                    'postal_code' => $customerData["profile"]['postal_code'] ?? "",
                    'city' => $customerData["profile"]['city'] ?? "",
                    'country' => $customerData["profile"]['country'] ?? "",
                    'email' => $customerData['email'] ?? "",
                    'bio' => $customerData["profile"]['bio'] ?? "",
                    'avatar' => $customerData["profile"]['avatar'] ?? "",
                    'linkedin' => $customerData["profile"]['linkedin'] ?? "",
                    'instagram' => $customerData["profile"]['instagram'] ?? "",
                    'twitter' => $customerData["profile"]['twitter'] ?? "",
                    'phone' => $customerData["profile"]['phone'] ?? null
                ];

                if (!User::where('id', $customer['id'])->exists()) {
                    User::insert([
                        'id' => $customer['id'],
                        'name' => $customer['name'],
                        'email' => $customer['email'],
                        'password' => bcrypt(time())
                    ]);
                }
                return response()->json([
                    'success' => true,
                    "customer" => $customer,
                    'message' => "UserAccount found in login.baaboo. function getUserAccountById"
                ]);
            }
        } catch (Exception $e) {
            return response([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}

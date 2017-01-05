<?php

namespace App\Http\Controllers;

use App\User;
use App\Property;
use Faker\Factory as Faker;
use Faker\Generator as FakerGenerator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use RegistersUsers;

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:3',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'api_token' => str_random(60),
        ]);
    }

    protected function generateRandomProperties(FakerGenerator $faker, $user_id)
    {
        return Property::create([
            'address' => $faker->address,
            'latitude' => $faker->latitude,
            'longitude' => $faker->longitude,
            'user_id' => $user_id,
        ]);
    }

    public function createUser(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails())
            return response()->json($validator->messages(), 200);

        $validator->validate();

        $user = $this->create($request->all());

        $faker = Faker::create();

        //Generate Random Properties and relate it to User
        for($i = 0; $i < 3; $i++)
            $this->generateRandomProperties($faker, $user->id);

        return response()->json(array('message' => 'User created successfully!'), 200);
    }

    protected function loginValidator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);
    }

    public function login(Request $request)
    {

        $user = DB::table('users')->where('email', $request->email)->first();

        if($user == null)
            return response()->json(array('error' => 'User not Registered!'), 200);

        $checkPassword = Hash::check($request->password, $user->password);

        if($checkPassword == false)
            return response()->json(array('error' => 'Wrong Password!'), 200);

        return $user->api_token;

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PeopleController extends Controller
{
    public function show($id)
    {
        $people = People::find($id);

        if (count($people)) {
            return response()->json(['status' => 'success', 'data' => ['people' => $people]], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function showAll()
    {
        $people = People::all();

        if (count($people)) {
            return response()->json(['status' => 'success', 'data' => $people], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|unique:people',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'data' => [
                    'name' => 'required',
                    'email' => 'required|unique',
                ]], 400);
        }

        $create = People::create($data);

        if (count($create)) {
            return response()->json(['status' => 'success'], 201);
        }

        return response()->json(['status' => 'error'], 500);
    }

    public function update(Request $request, $id)
    {
        $people = People::find($id);

        if (count($people)) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'sometimes|required',
                'email' => [
                    'sometimes',
                    'required',
                    Rule::unique('people')->ignore($id, 'id'),
                ],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'data' => [
                        'name' => 'required',
                        'email' => 'required|unique_key',
                    ]], 400);
            }

            $people->fill($data)->save();
            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'no data'], 404);
    }

    public function delete($id)
    {
        $people = People::find($id);

        if (count($people)) {
            $people->delete();
            return response()->json(['status' => 'success', 'data' => null], 200);
        }
        return response()->json(['status' => 'error'], 404);
    }
}
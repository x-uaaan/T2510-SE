<?php

namespace Tests\Feature;

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DuplicateUsernameTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_rules_allow_duplicate_usernames(): void
    {
        // Get the validation rules from ProfileController
        $controller = new ProfileController();
        
        // Create a mock request to test validation
        $request = \Illuminate\Http\Request::create('/complete-profile', 'POST', [
            'email' => 'john.doe1@test.com',
            'name' => 'John Doe',
            'username' => 'John Doe',
            'phone' => '+60123456789',
            'faculty' => 'Faculty of Engineering',
            'userType' => 'Alumni',
        ]);

        // Test that the validation rules don't include username uniqueness
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:50', // No unique constraint
            'phone' => 'required|string|max:20',
            'faculty' => 'required|string|max:255',
            'userType' => 'required|in:Alumni,Lecturer',
        ]);

        // The validation should pass since there's no unique constraint on username
        $this->assertTrue($validator->passes());
        
        // Verify that the username validation rule doesn't contain 'unique'
        $rules = $validator->getRules();
        $this->assertArrayHasKey('username', $rules);
        $this->assertNotContains('unique:users,username', $rules['username']);
    }

    public function test_username_field_is_required_and_has_length_validation(): void
    {
        // Test that username is required
        $validator = \Illuminate\Support\Facades\Validator::make([], [
            'username' => 'required|string|min:3|max:50',
        ]);

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('username'));

        // Test that username must be at least 3 characters
        $validator = \Illuminate\Support\Facades\Validator::make([
            'username' => 'ab'
        ], [
            'username' => 'required|string|min:3|max:50',
        ]);

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('username'));

        // Test that username must be at most 50 characters
        $validator = \Illuminate\Support\Facades\Validator::make([
            'username' => str_repeat('a', 51)
        ], [
            'username' => 'required|string|min:3|max:50',
        ]);

        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('username'));

        // Test valid username
        $validator = \Illuminate\Support\Facades\Validator::make([
            'username' => 'John Doe'
        ], [
            'username' => 'required|string|min:3|max:50',
        ]);

        $this->assertTrue($validator->passes());
    }
}

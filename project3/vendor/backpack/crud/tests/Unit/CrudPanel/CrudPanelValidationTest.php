<?php

namespace Backpack\CRUD\Tests\Unit\CrudPanel;

use Backpack\CRUD\Tests\Unit\Http\Requests\UserRequest;
use Backpack\CRUD\Tests\Unit\Models\User;

/**
 * @covers Backpack\CRUD\app\Library\CrudPanel\Traits\Validation
 */
class CrudPanelValidationTest extends BaseDBCrudPanelTest
{
    public function testItThrowsValidationExceptions()
    {
        $this->crudPanel->setModel(User::class);
        $this->crudPanel->setValidation(UserRequest::class);

        $request = request()->create('users/', 'POST', [
            'email'    => 'test@test.com',
            'password' => 'test',
        ]);

        $this->crudPanel->setRequest($request);
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $validatedRequest = $this->crudPanel->validateRequest();
    }

    public function testItMergesFieldValidationWithRequestValidation()
    {
        $this->crudPanel->setModel(User::class);
        $this->crudPanel->setValidation(UserRequest::class);

        $request = request()->create('users/', 'POST', [
            'name'     => 'test name',
            'email'    => 'test@test.com',
            'password' => 'test',
        ]);

        $request->setRouteResolver(function () use ($request) {
            return (new Route('POST', 'users', ['Backpack\CRUD\Tests\Unit\Http\Controllers\UserCrudController', 'create']))->bind($request);
        });

        $this->crudPanel->addFields([
            [
                'name'            => 'email',
                'validationRules' => 'required',
            ],
            [
                'name' => 'name',
            ],
            [
                'name' => 'password',
            ],
        ]);

        $this->crudPanel->setRequest($request);

        $this->crudPanel->validateRequest();

        $this->assertEquals(['email'], array_keys($this->crudPanel->getOperationSetting('validationRules')));
    }

    public function testItMergesAllKindsOfValidation()
    {
        $this->crudPanel->setModel(User::class);

        $this->crudPanel->setOperation('create');
        $this->crudPanel->setValidation([
            'password' => 'required',
        ]);
        $this->crudPanel->setValidation(UserRequest::class);

        $request = request()->create('users/', 'POST', [
            'name'     => '',
            'password' => '',
            'email'    => '',
        ]);

        $request->setRouteResolver(function () use ($request) {
            return (new Route('POST', 'users', ['Backpack\CRUD\Tests\Unit\Http\Controllers\UserCrudController', 'create']))->bind($request);
        });

        $this->crudPanel->addFields([
            [
                'name'            => 'email',
                'validationRules' => 'required',
            ],
            [
                'name' => 'name',
            ],
            [
                'name' => 'password',
            ],
        ]);

        $this->crudPanel->setRequest($request);

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        try {
            $this->crudPanel->validateRequest();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->assertEquals(['password', 'email', 'name'], array_keys($e->errors()));
            throw $e;
        }
    }

    public function testItCanGetTheValidationFromFields()
    {
        $this->crudPanel->setModel(User::class);
        $this->crudPanel->setOperation('create');

        $request = request()->create('users/', 'POST', [
            'name'     => 'test name',
            'email'    => 'test@test.com',
            'password' => 'test',
        ]);

        $request->setRouteResolver(function () use ($request) {
            return (new Route('POST', 'users', ['Backpack\CRUD\Tests\Unit\Http\Controllers\UserCrudController', 'create']))->bind($request);
        });

        $this->crudPanel->addField([
            'name'            => 'email',
            'validationRules' => 'required',
        ]);

        $this->crudPanel->addField([
            'name'               => 'name',
            'validationRules'    => 'required',
            'validationMessages' => [
                'required' => 'required ma friend',
            ],
        ]);

        $this->crudPanel->addField([
            'name'      => 'password',
            'subfields' => [
                [
                    'name'               => 'test',
                    'validationRules'    => 'required',
                    'validationMessages' => [
                        'required' => 'required ma friend',
                    ],
                ],
            ],
        ]);

        $this->crudPanel->setRequest($request);

        $this->crudPanel->setValidation();

        $validatedRequest = $this->crudPanel->validateRequest();

        $this->assertEquals(['email', 'name', 'password.*.test'], array_keys($this->crudPanel->getOperationSetting('validationRules')));
    }

    public function testItThrowsExceptionWithInvalidValidationClass()
    {
        $this->crudPanel->setModel(User::class);
        $this->crudPanel->setOperation('create');

        try {
            $this->crudPanel->setValidation('\Backpack\CRUD\Tests\Unit\Models\User');
        } catch (\Throwable $e) {
        }
        $this->assertEquals(
            new \Symfony\Component\HttpKernel\Exception\HttpException(500, 'Please pass setValidation() nothing, a rules array or a FormRequest class.'),
            $e
        );
    }

    public function testItCanDisableTheValidation()
    {
        $this->crudPanel->setModel(User::class);
        $this->crudPanel->setOperation('create');
        $this->crudPanel->setValidation([
            'name'     => 'required',
            'password' => 'required',
        ]);
        $this->crudPanel->setValidation(UserRequest::class);
        $this->assertEquals(['name', 'password'], array_keys($this->crudPanel->getOperationSetting('validationRules')));

        $this->crudPanel->disableValidation();
        $this->assertEquals([], $this->crudPanel->getOperationSetting('validationRules'));
        $this->assertEquals([], $this->crudPanel->getOperationSetting('validationMessages'));
        $this->assertEquals([], $this->crudPanel->getOperationSetting('requiredFields'));
        $this->assertEquals(false, $this->crudPanel->getFormRequest());
    }

    public function testItCanGetTheRequiredFields()
    {
        $this->crudPanel->setModel(User::class);
        $this->crudPanel->setOperation('create');
        $this->assertFalse($this->crudPanel->isRequired('test'));
        $this->crudPanel->setValidation([
            'email'     => 'required',
            'password.*.test' => 'required',
        ]);

        $this->crudPanel->setValidation(UserRequest::class);
        $this->assertEquals(['email', 'password[test]', 'name'], array_values($this->crudPanel->getOperationSetting('requiredFields')));
        $this->assertTrue($this->crudPanel->isRequired('email'));
        $this->assertTrue($this->crudPanel->isRequired('password.test'));
        $this->assertTrue($this->crudPanel->isRequired('name'));
    }
}

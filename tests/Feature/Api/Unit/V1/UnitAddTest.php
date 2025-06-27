<?php


use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Carbon;
use function Pest\Laravel\postJson;

uses( \Illuminate\Foundation\Testing\RefreshDatabase::class);

test( 'API creates new unit (full details)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('token-name')->plainTextToken;

    $unit = Unit::factory()->make()->toArray();

    $nationalCode = $unit['national_code'];
    //$aqfLevel = $unit['aqf_level'];
    $title = $unit['title'];
    $tgaStatus = $unit['tga_status'];
    $stateCode = $unit['state_code'];
    $nominalHours = $unit['nominal_hours'];
    $type = $unit['type'];
    $qa = $unit['qa'];



    $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])
        ->postJson(route('api.v1.units.store', $unit));

    $response->assertStatus(201)
    ->assertJson([
        'success',
        'message',
        'data' =>
            [
                'national_code',
                //'aqf_level',
                'title',
                'tga_status',
                'state_code',
                'nominal_hours',
                'type',
                'qa'
            ]
    ])
        ->assertJson([
            'success' => true,
            'message' => 'unit added',
            'data' => [
                'national_code' => $nationalCode,
                //'aqf_level' => $aqfLevel,
                'title' => $title,
                'tga_status' => $tgaStatus,
                'state_code' => $stateCode,
                'nominal_hours' => $nominalHours,
                'type' => $type,
                'qa' => $qa
            ]
        ]);

    $unit = Unit::where('unit_code', $nationalCode)->first();
    $this->assertNotNull($unit);
    $this->assertTrue(Carbon::parse($unit->created_at)->diffInSeconds(now()) <= 5);
    $this->assertTrue(Carbon::parse($unit->updated_at)->diffInSeconds(now()) <= 5);
});
test('API creates new units (national_code, title, tga_status, state_code, nominal_hours, type, qa)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $unit = Unit::factory()->make(
        [
            'qa' => null,
        ]
    )->toArray();

    $nationalCode = $unit['national_code'];
    $aqfLevel = $unit['aqf_level'];
    $title = $unit['title'];
    $tgaStatus = $unit['tga_status'];
    $stateCode = $unit['state_code'];
    $nominalHours = $unit['nominal_hours'];
    $type = $unit['type'];
    $qa = $unit['qa'];

    $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])
        ->postJson(route('api.v1.units.store', $unit));
    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'national_code',
                'aqf_level',
                'title',
                'tga_status',
                'state_code',
                'nominal_hours',
                'type',
            ]
        ])

        ->assertJson([
            'success' => true,
            'message' => 'unit added',
            'data' => [
                'national_code' => $nationalCode,
                'aqf_level' => $aqfLevel,
                'title' => $title,
                'tga_status' => $tgaStatus,
                'state_code' => $stateCode,
                'nominal_hours' => $nominalHours,
                'type' => $type,
            ]
        ]);

    $unit = Unit::where('unit_code', $nationalCode)->first();
    $this->assertNotNull($unit);
    $this->assertTrue(Carbon::parse($unit->created_at)->diffInSeconds(now()) <= 5);
    $this->assertTrue(Carbon::parse($unit->updated_at)->diffInSeconds(now()) <= 5);
});

test('an error is returned when national_code, title, tga_status, state_code an nominal_hours are not provided', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $data = [
        'qa' => 'FFF0',
    ];

    $response = $this->withHeaders('Authorization', 'Bearer ' . $token)
        ->postJson(route('api.v1.units.store'), $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'national_code',
            'aqf_level',
            'title',
            'tga_status',
            'state_code',
            'nominal_hours',
            'type',
        ]);
});

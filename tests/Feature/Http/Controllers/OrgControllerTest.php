<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Org;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrgController
 */
final class OrgControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $orgs = Org::factory()->count(3)->create();

        $response = $this->get(route('orgs.index'));

        $response->assertOk();
        $response->assertViewIs('org.index');
        $response->assertViewHas('orgs');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('orgs.create'));

        $response->assertOk();
        $response->assertViewIs('org.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrgController::class,
            'store',
            \App\Http\Requests\OrgStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $response = $this->post(route('orgs.store'));

        $response->assertRedirect(route('orgs.index'));
        $response->assertSessionHas('org.id', $org->id);

        $this->assertDatabaseHas(orgs, [ /* ... */ ]);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $org = Org::factory()->create();

        $response = $this->get(route('orgs.show', $org));

        $response->assertOk();
        $response->assertViewIs('org.show');
        $response->assertViewHas('org');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $org = Org::factory()->create();

        $response = $this->get(route('orgs.edit', $org));

        $response->assertOk();
        $response->assertViewIs('org.edit');
        $response->assertViewHas('org');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrgController::class,
            'update',
            \App\Http\Requests\OrgUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $org = Org::factory()->create();

        $response = $this->put(route('orgs.update', $org));

        $org->refresh();

        $response->assertRedirect(route('orgs.index'));
        $response->assertSessionHas('org.id', $org->id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $org = Org::factory()->create();

        $response = $this->delete(route('orgs.destroy', $org));

        $response->assertRedirect(route('orgs.index'));

        $this->assertSoftDeleted($org);
    }
}

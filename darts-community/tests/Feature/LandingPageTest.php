<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_returns_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_landing_page_displays_hero_section(): void
    {
        $response = $this->get('/');

        $response->assertSee('Votre identité de joueur');
        $response->assertSee('comme les pros');
        $response->assertSee('Créer mon profil');
        $response->assertSee('Découvrir');
    }

    public function test_landing_page_displays_feature_cards(): void
    {
        $response = $this->get('/');

        $response->assertSee('Profil Joueur');
        $response->assertSee('Mon Setup');
        $response->assertSee('Communauté');
    }

    public function test_landing_page_uses_french_language(): void
    {
        $response = $this->get('/');

        $response->assertSee('lang="fr"', false);
    }

    public function test_landing_page_includes_tailwind_cdn(): void
    {
        $response = $this->get('/');

        $response->assertSee('cdn.tailwindcss.com', false);
    }

    public function test_landing_page_includes_inter_font(): void
    {
        $response = $this->get('/');

        $response->assertSee('fonts.googleapis.com', false);
        $response->assertSee('Inter', false);
    }

    public function test_landing_page_has_responsive_viewport_meta(): void
    {
        $response = $this->get('/');

        $response->assertSee('viewport', false);
        $response->assertSee('width=device-width', false);
    }
}

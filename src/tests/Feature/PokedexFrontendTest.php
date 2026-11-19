<?php

namespace Tests\Feature;

use App\Models\Pokemon;
use Database\Seeders\PokemonSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PokedexFrontendTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_pokedex(): void
    {
        $this->get('/')->assertRedirect('/pokedex');
    }

    public function test_pokedex_landing_page_renders_hero_bento_table_and_modal(): void
    {
        $this->seed(PokemonSeeder::class);

        $this->assertSame(200, Pokemon::count());

        $response = $this->get('/pokedex');

        $response->assertOk()
            ->assertSee('<title>Pokedex</title>', false)
            ->assertDontSee('Crimson Dark Pokédex', false)
            ->assertSee('Pokedex - Arya Andra Diazka - J0404251155 - A / A2', false)
            ->assertSee('id="home"', false)
            ->assertSee('id="explore"', false)
            ->assertSee('id="search"', false)
            ->assertSee('id="showcase"', false)
            ->assertSee('id="drawer"', false)
            ->assertSee('closedby="any"', false)
            ->assertSee('Struktur Excel', false)
            ->assertSee('Validasi Import', false)
            ->assertSee('Export ke Excel', false)
            ->assertSee('Import Excel', false)
            ->assertSee('Bulbasaur', false)
            ->assertSee('Chikorita', false)
            ->assertSee('Misdreavus', false)
            ->assertSee('#0001', false)
            ->assertSee('#0151', false)
            ->assertSee('#0152', false)
            ->assertSee('#0200', false)
            ->assertSee('Generasi I (Kanto)', false)
            ->assertSee('Generasi II (Johto)', false)
            ->assertSee('window.POKEDEX', false);
    }

    public function test_export_downloads_xlsx_with_timestamped_filename(): void
    {
        $this->seed(PokemonSeeder::class);

        $response = $this->get('/pokedex/export');

        $response->assertOk();
        $disposition = (string) $response->headers->get('content-disposition');
        $this->assertMatchesRegularExpression('/Pokedex_Library_\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}\.xlsx/', $disposition);
    }

    public function test_import_validates_three_statuses_and_inserts_valid_rows(): void
    {
        $this->seed(PokemonSeeder::class);

        $samplePath = public_path('sample_import_pokemon.xlsx');
        $uploaded = new UploadedFile(
            $samplePath,
            'sample_import_pokemon.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true,
        );

        $response = $this->post('/pokedex/import', [
            'file_excel' => $uploaded,
        ]);

        $response->assertRedirect('/pokedex')
            ->assertSessionHas('import_result', [
                'file' => 'sample_import_pokemon.xlsx',
                'berhasil' => 3,
                'duplikat' => 2,
                'tidak_valid' => 2,
                'new_ids' => ['#0201', '#0202', '#0203'],
            ]);

        $this->assertDatabaseHas('pokemons', ['nomor_index' => '#0201', 'nama_pokemon' => 'Unown']);
        $this->assertDatabaseHas('pokemons', ['nomor_index' => '#0202', 'nama_pokemon' => 'Wobbuffet']);
        $this->assertDatabaseHas('pokemons', ['nomor_index' => '#0203', 'nama_pokemon' => 'Girafarig']);
        $this->assertSame(203, Pokemon::count());
    }
}

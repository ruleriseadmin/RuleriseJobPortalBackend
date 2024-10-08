<?php

use App\Models\Domain\Admin\AdminUser;
use App\Models\Domain\Shared\WebsiteCustomization;
use Database\Seeders\OnTimeWebsiteCustomizationSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(OnTimeWebsiteCustomizationSeeder::class);
});

test('That admin set website customization', function () {

    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post('/v1/admin/website-customization', [
        'type' => 'hero_section',
        'sections' => [
            ['name' => 'banner_one', 'value' => 'Founders vision'],
            ['name' => 'subtitle_one', 'value' => 'Hello'],
            ['name' => 'banner_two', 'value' => 'Hello'],
            ['name' => 'subtitle_two', 'value' => 'Hello'],
            ['name' => 'subtitle_three', 'value' => 'Hello'],
            ['name' => 'banner_three', 'value' => 'Hello'],
        ],
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(WebsiteCustomization::first()->value)->toBeString('Founders vision');
});

test('That admin view website customization', function () {
    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->get('/v1/admin/website-customization/hero_section');

    expect($response->json()['status'])->toBe('200');
});

test('That admin website customization add new contact', function () {
    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post('/v1/admin/website-customization/createNewContact', [
        'title' => 'twitter',
        'link' => 'twitter.com/account',
    ]);

    expect($response->json()['status'])->toBe('200');

    expect(WebsiteCustomization::where('name', 'twitter')->first()->value)->toBe('twitter.com/account');
});

test('That admin website customization - upload image', function () {
    $user = AdminUser::factory()->create();

    $response = $this->actingAs($user)->post('/v1/admin/website-customization/uploadImage', [
        'type' => 'hero_section',
        'imageInBase64' => '/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBw0NDQ8NDQ0NDg4PDQ0PDxAODRANFQ4NFRUWFhUXFRgYHSggGBsxGxUVITEhJSkrLi4uFx8zODMtNygtLisBCgoKBQUFDgUFDisZExkrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrKysrK//AABEIAOEA4QMBIgACEQEDEQH/xAAaAAEAAwEBAQAAAAAAAAAAAAAAAQUGBAMC/8QAOxABAAIBAAcEBwUGBwAAAAAAAAECAwQFESExQVESImFxEzJSgZGh0QZicrHBQoKSouHwIzNDg7LC8f/EABQBAQAAAAAAAAAAAAAAAAAAAAD/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwDegAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABD0rgyTwpef3ZB5j1nRssccd/4JedqzHGJjziYBAAAAAAAAAAAAAAAAAAAAAAA+8OK17RWkbbTyaDQNVUxbLX2Xv8AKvl9QVOiary5d+zsV62j8oWuDU+Gvrbck+O6PhCxAfGPDSvq0rXyiIeiAEvm1YndMRPnG1IDkzatwX/Yis9a938lZpOpL1347duPZndPx4SvgGNvSazstE1mOUxslDW6VomPNGy8eUxumPKWd0/QL4J396kzutH5T0kHIAAAAAAAAhIAAAAAAA+8OK2S0UrG2Zl8NJqjQvRU7Vo79ojb92OgPbQNCrhrsjfafWt1n6OkAAAAAAAAAEXpFomtoiYmNkxPNIDM6z0CcNtsbZxzPdnpPSXE2GfFXJWaWjbExvZTStHnFeaW5cJ615SDyAAAAAAAAAAAAAB36n0b0mWJmO7TvT4zyj++jSODUuDsYYnnee1Ply+TvABIIEgIEgIEgIEgIEgIVmvdG7eP0kR3qcfGnP6rRFqxMTE8JiYnyBjB6aRi7F7U9m0x7uXyeYAAAAAAAAAACa12zERxmYiPOUPfQa7c2OPv1Bq6VisRWOERER5QkAEoSAAAAAAAAAAAADOa9x9nNt9qsT743K5c/aOu/FPhkj/ipgAAAAAAAAAAHTq6f8fH+OHM9MF+zelul6z7toNeAAlCQAAAAAAAAAAAAUv2j/0v9z/qpVt9ob7clK+zWZ+M/wBFSAAAAAAAAAAAADWaBm9JipbrWNvnG6Xupvs/pHrYp/FX9VyAlCQAAAAAAAAAAAc+n6R6LFa/PZsr+KeAM9rTL28955RPZj3bvz2uQAAAAAAAAAAAAAemDLOO9b141nb59YavR81clIvXhMfDwZB36p070Nuzaf8ADtO/7s9QaRKInbvSAAAAAAAAAAAzuutL9JfsVnuU+d+bv1xrD0cejpPfmN8+xH1Z4AAAAAAAAAAAAAAAAFlqzWc4u5ffj5Txmn9GgpeLRE1mJieExO3axrp0PTcmGe7O2vOs8J+gNWODRNa4sm6Z7Fulp5+Eu8AAAAAHhpGl48Ud+0R4cZn3A91ZrLWkY9tMey2ThM8Yp5+Lh03W98m2uPbSvXb3p+isBNrTMzMztmZ2zM85QAAAAAAAAAAAAAAAAJrWZnZETM9IjaCBYYNUZr75iKR96d/wh9aTqbJSNtJjJHOI3T/UFa98GmZcfqXtEdPWj4S8bVmJ2TExPSY2IBa4teZI9albeW2r3rr2vPFb3WiVGAvZ17Tljv75rDyvr2f2ccR522qcB25taZ77u32Y6ViI+fFxzO2ds756ygAHXoursuXhXs19q27/ANdWbUmSI20tW3hPdBVD1zYL452XrNfON3xeQAAAAAAAAAAAAAmtZtMViJmZnZERzlodW6sriiL32WyfGK+Xj4g4dB1Pa+y2XbSvs/tT9F1o+jY8UbKViPHnPnL2AAAeWbR6ZI2XpW3nDgzakxT6trU/mj5rQBQX1Hkj1b0t5xNfq8p1Pn6Vn95pAGajVGkezH8UPSmpM08ZpHvmWhAU+LUUR6+SZ8K17P1d2DV+HH6tI29bd6fm6gAAHzasWjZMRMdJjaq9M1NW2/FPYn2Z3xP0WwDHZsVsduzes1mOv6dXw1ul6LTNXs3jynnWfBmtN0S2G3ZtvifVtHCY+oOcAAAAAAAAFlqXRPSX7do7tJ+N/wC9/wAAd+p9A9HX0l479o4exH1WSQECQAAAAAAAAAAAAAAB46Vo9ctJpbhPCek9YewDIaTgtivNLcY+ccpeTR650T0mPtVjv03x415wzgAAAAAAERyjj+rW6Fo8Ysdac4jf425qDU2Dt5omeFI7U+fL+/BpgEJAQJAAAAAAAAAAAAAAAAAGW1po3ostoj1bd6vlPJqVXr7B2scXjjSf5Z4/oDPgAAAAAuPs7xyeVP1XaQECQEAAAAAAAACQECQAAAAAABy6z/yMn4JAGVAAAB//2Q==',
        'imageExtension' => 'jpeg',
        'imageBox' => '1',
    ]);

    $response = $this->actingAs($user)->post('/v1/admin/website-customization/uploadImage', [
        'type' => 'hero_section',
        'imageInBase64' => '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',
        'imageExtension' => 'jpeg',
        'imageBox' => '2',
    ]);

    $response = $this->actingAs($user)->post('/v1/admin/website-customization/uploadImage', [
        'type' => 'hero_section',
        'imageBox' => '2',
        'imageInBase64' => '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',
        'imageExtension' => 'png',
    ]);

    expect($response->json()['status'])->toBe('200');

    $response = $this->actingAs($user)->get('/v1/admin/website-customization/hero_section');

    expect($response->json()['status'])->toBe('200');
});

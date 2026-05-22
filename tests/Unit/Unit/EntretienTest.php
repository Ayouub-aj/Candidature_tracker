<?php

use App\Models\Entretien;
use App\Models\Candidature;

test('it returns type label in French', function () {
    $entretien = new Entretien();

    $entretien->type = 'phone';
    expect($entretien->type_label)->toBe('Téléphonique');

    $entretien->type = 'video';
    expect($entretien->type_label)->toBe('Visioconférence');

    $entretien->type = 'onsite';
    expect($entretien->type_label)->toBe('Présentiel');

    $entretien->type = 'technical';
    expect($entretien->type_label)->toBe('Technique');

    $entretien->type = 'hr';
    expect($entretien->type_label)->toBe('RH');
});

test('it returns result label in French', function () {
    $entretien = new Entretien();

    $entretien->result = 'pending';
    expect($entretien->result_label)->toBe('En attente');

    $entretien->result = 'passed';
    expect($entretien->result_label)->toBe('Réussi');

    $entretien->result = 'failed';
    expect($entretien->result_label)->toBe('Échoué');
});

test('it belongs to a candidature', function () {
    $entretien = new Entretien();
    expect(method_exists($entretien, 'candidature'))->toBeTrue();
});
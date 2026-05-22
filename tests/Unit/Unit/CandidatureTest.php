<?php

use App\Models\Candidature;
use App\Models\User;
use App\Models\Entretien;

test('it has correct fillable fields', function () {
    $candidature = new Candidature();

    expect($candidature->getFillable())->toBe([
        'user_id',
        'company',
        'position',
        'offer_url',
        'status',
        'priority',
        'notes',
        'applied_at',
    ]);
});

test('it returns status label in French', function () {
    $candidature = new Candidature();

    $candidature->status = 'sent';
    expect($candidature->status_label)->toBe('Envoyée');

    $candidature->status = 'interview';
    expect($candidature->status_label)->toBe('Entretien');

    $candidature->status = 'offer';
    expect($candidature->status_label)->toBe('Offre reçue');

    $candidature->status = 'rejected';
    expect($candidature->status_label)->toBe('Refusée');

    $candidature->status = 'withdrawn';
    expect($candidature->status_label)->toBe('Retirée');
});

test('it returns priority label in French', function () {
    $candidature = new Candidature();

    $candidature->priority = 'low';
    expect($candidature->priority_label)->toBe('Basse');

    $candidature->priority = 'medium';
    expect($candidature->priority_label)->toBe('Moyenne');

    $candidature->priority = 'high';
    expect($candidature->priority_label)->toBe('Haute');
});

test('it belongs to a user', function () {
    $candidature = new Candidature();
    expect(method_exists($candidature, 'user'))->toBeTrue();
});

test('it has many entretiens', function () {
    $candidature = new Candidature();
    expect(method_exists($candidature, 'entretiens'))->toBeTrue();
});
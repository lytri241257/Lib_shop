<?php

namespace App\DTO;

class SearchCriteria
{
    public ?string $titre = null;
    public ?string $auteur = null;
    public ?string $description = null;
    public ?string $categorie = null;
    public ?string $revendeur = null;
    public ?float $minPrix = null;
    public ?float $maxPrix = null;
    public ?int $page = 1;
    public ?int $limit = 25;
    public ?string $orderBy = 'datedemisejour';
    public ?string $direction = 'DESC';

}
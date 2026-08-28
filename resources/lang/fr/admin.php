<?php

return [
    'nav' => 'Codes créateur',
    'title' => 'Codes créateur',
    'created' => 'Créateur ajouté.',
    'updated' => 'Créateur mis à jour.',
    'deleted' => 'Créateur supprimé.',
    'add' => 'Ajouter un créateur',
    'fields' => [
        'pseudo' => 'Pseudo',
        'code' => 'Code',
        'percentage' => 'Pourcentage',
        'status' => 'Statut',
        'neos' => 'Neos versés',
    ],
    'status' => [
        'enabled' => 'Actif',
        'disabled' => 'Inactif',
    ],
    'help' => [
        'pseudo' => 'Doit correspondre au compte Azuriom du créateur (pour créditer les neos).',
        'code' => 'Code que le joueur tapera dans la boutique.',
        'percentage' => 'Le créateur reçoit ce % des neos achetés, en plus. Rien n’est retiré au joueur.',
    ],
    'errors' => [
        'user' => 'Aucun compte Azuriom avec ce pseudo.',
        'duplicate_user' => 'Ce joueur a déjà un code créateur.',
    ],
    'permissions' => [
        'manage' => 'Gérer les codes créateur',
    ],
    'empty' => 'Aucun créateur.',
    'logs' => [
        'creatorcodes-creators' => [
            'created' => 'Code créateur créé',
            'updated' => 'Code créateur modifié',
            'deleted' => 'Code créateur supprimé',
        ],
    ],
];

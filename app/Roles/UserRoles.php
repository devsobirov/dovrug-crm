<?php


namespace App\Roles;


class UserRoles
{
    const ROLE_DIRECTOR = 'director';
    const ROLE_ADMINISTRATOR = 'administrator';
    const ROLE_DESIGNER = 'designer';
    const ROLE_ACCOUNTANT = 'accountant';
    const ROLE_DEPOSITOR = 'depositor';

    public static $roleHierarchy = [
        self::ROLE_DIRECTOR => [
            self::ROLE_ADMINISTRATOR,
            self::ROLE_DESIGNER,
            self::ROLE_ACCOUNTANT,
            self::ROLE_DEPOSITOR,
        ],
        self::ROLE_ADMINISTRATOR =>  [
            self::ROLE_DESIGNER,
            self::ROLE_ACCOUNTANT,
            self::ROLE_DEPOSITOR,
        ],
        self::ROLE_DESIGNER => [],
        self::ROLE_ACCOUNTANT => [],
        self::ROLE_DEPOSITOR => []
    ];

    public static function getRolesList() {
        return [
            self::ROLE_DIRECTOR => 'Директор',
            self::ROLE_ADMINISTRATOR => 'Администратор',
            self::ROLE_DESIGNER => 'Дизайнер',
            self::ROLE_ACCOUNTANT => 'Кассир',
            self::ROLE_DEPOSITOR => 'Складчик'
        ];
    }

    public static function getColorsForRoles() {
        return [
            self::ROLE_DIRECTOR => 'purple',
            self::ROLE_ADMINISTRATOR => 'yellow',
            self::ROLE_DESIGNER => 'red',
            self::ROLE_ACCOUNTANT => 'blue',
            self::ROLE_DEPOSITOR => 'green'
        ];
    }
}

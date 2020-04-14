<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class UserCest
{
    const URL = '/books/';

    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage(self::URL);

        $I->see('Book Store');
    }
}

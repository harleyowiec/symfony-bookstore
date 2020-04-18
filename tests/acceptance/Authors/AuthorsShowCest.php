<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class AuthorsShowCest
{
    private const AUTHOR_ID = 88;
    private const URL = '/authors/'. self::AUTHOR_ID;

    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I): void
    {
        $I->haveInDatabase('author', [
            'id' => self::AUTHOR_ID,
            'name' => 'Testing author',
            'surname' => 'Test surname',
            'birth_date' => '1992-01-01',
            'nickname' => 'lalal',
            'created' => '2020-04-08 19:01:05'
        ]);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryToShowBook(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('Name: Testing author');
        $I->see('lalal');
    }
}

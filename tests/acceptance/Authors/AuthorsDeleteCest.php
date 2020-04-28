<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class AuthorsDeleteCest
{
    private const URL = '/authors';
    private const AUTHOR_ID = 88;


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
    public function tryToDeleteBook(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('Testing author');
        $I->click('//a[@href="/authors/'.self::AUTHOR_ID.'/delete"]');

        $I->see('All authors');
        $I->dontSee('Testing author');
    }
}

<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class AuthorsIndexCest
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
    public function tryToDisplayAllBooks(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('All authors');
        $I->seeElement('.author-row');
        $I->see('Testing author');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryToDisplayEditView(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->click('//a[@href="/authors/'.self::AUTHOR_ID.'/edit"]');
        $I->see('Edit author:');
        $I->seeInField(['name' => 'author[name]'],'Testing author');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryToDisplayShowView(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->click('//a[@href="/authors/'.self::AUTHOR_ID.'"]');
        $I->see('Name: Testing author');
    }
}

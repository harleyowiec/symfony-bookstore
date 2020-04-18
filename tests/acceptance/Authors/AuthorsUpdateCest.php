<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class AuthorsUpdateCest
{
    private const URL = '/authors/'.self::AUTHOR_ID.'/edit';
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
    public function tryUpdateAuthor(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('Edit author:');
        $I->seeInField(['name' => 'author[name]'],'Testing author');
        $I->fillField(['name' => 'author[name]'],'Edited author');
        $I->click('Save');

        $I->see('All authors');
        $I->see('Edited author');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryUpdateAuthorWithoutName(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('Edit author:');
        $I->seeInField(['name' => 'author[name]'],'Testing author');
        $I->fillField(['name' => 'author[name]'],'');
        $I->click('Save');

        $I->dontSee('All authors');
        $I->see('Edit author:');
        $I->seeInField(['name' => 'author[name]'],'');
    }
}

<?php namespace App\Tests\Acceptance;

use AcceptanceTester;

class AuthorsStoreCest
{
    private const URL = '/authors/create';
    private const AUTHOR_ID = 91;


    /**
     * @param AcceptanceTester $I
     */
    public function tryToCreateAuthor(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('Add new author:');
        $I->fillField(['name' => 'author[name]'],'Fresh added author');
        $I->fillField(['name' => 'author[surname]'],'Test surname');
        $I->fillField(['name' => 'author[birth_date]'],'02/02/1995');
        $I->click('Save');

        $I->see('All authors');
        $I->see('Fresh added author');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function tryCreateAuthorWithoutName(AcceptanceTester $I): void
    {
        $I->amOnPage(self::URL);

        $I->see('Add new author:');
        $I->fillField(['name' => 'author[name]'],'');
        $I->click('Save');

        $I->dontSee('All authors');
        $I->see('Add new author:');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function _after(AcceptanceTester $I): void
    {
        $I->deleteFromDatabase('author', [
            'name' =>'Fresh added author'
        ]);
    }
}

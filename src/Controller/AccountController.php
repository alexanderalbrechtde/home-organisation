<?php

namespace App\Controller;

use App\Entities\RoomEntity;
use App\Entities\UserEntity;
use App\Services\AccountService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;
use Framework\Services\OrmService;

class AccountController implements ControllerInterface
{

    public function __construct(
        private HtmlRenderer $htmlRenderer,
        private AccountService $accountService,
        private OrmService $ormService
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        $user = $this->accountService->showParameters($httpRequest->getSession()['user_id']);

        //User finden funktioniert
        //$user = $this->ormService->findById(2, UserEntity::class);

        //User löschen funktioniert
        //$this->ormService->delete($user);

        //User updaten funktioniert
        //$user->first_Name = 'Alexander';
        //$this->ormService->update($user);

        //User create funktioniert
        //$this->ormService->create($user);

        //User save funktioniert
        //$user->first_Name = 'Alexander';
        //$this->ormService->save($user);


        //$user->firstName = 'Jens';
        //$user->save($user);
        //$user2 = $this->ormService->save($user);

        //Find All
        //$users = $this->ormService->findAll(UserEntity::class);

        //FindBy
       //$users = $this->ormService->findBy(
       //    [
       //        [
       //            'name' => 'Bad',
       //        ],
       //    ]
       //    , RoomEntity::class, 4, []
       //);
       ////findBy mit neuer Logik
       $select = $this->ormService->findBy(
           [
               [
                   'name' => 'Bad',
               ],
           ],
           RoomEntity::class,
           5,
           [],

       );
        dd($select);

        //$user = $this->ormService->findById(
        //    1,
        //    UserEntity::class
        //);

        //update neu
        //$user = $this->ormService->findById(13, UserEntity::class );
        //$user->first_Name = 'Jens';
        //$update = $this->ormService->save($user);


        //FindOneBy
        //$users = $this->ormService->findOneBy([
        //    'first_Name' => 'Alexander'
        //], UserEntity::class);

        //dd($users);

        //Delete
        //$user = $this->ormService->findById(13, UserEntity::class);
        //$deleted = $this->ormService->delete($user);
        //$this->ormService->delete($user);

        //dd($deleted);

        //create
        //$user = new UserEntity();
        //$user->first_Name = 'Jens';
        //$user->last_Name = 'Prangenberg';
        //$user->email = 'jp@check.de';
        //$user->password = '1234567';
        //$insert = $this->ormService->create($user);
        //dd($insert);

        return new HtmlResponse($this->htmlRenderer->render('account.phtml', [
            'user' => $user,
        ]));
    }
}
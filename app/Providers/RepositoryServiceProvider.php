<?php

namespace App\Providers;

use App\Interfaces\CarsDetailInterface;
use App\Interfaces\CategoriesInterface;
use App\Interfaces\CategoryAlgoInterface;
use App\Interfaces\CImportQuestionInterface;
use App\Interfaces\ClinicianCategoriesInterface;
use App\Interfaces\FinalPageResponseInterface;
use App\Interfaces\HealthBoardInterface;
use App\Interfaces\ImportQuestionInterface;
use App\Interfaces\InformantCategoriesInterface;
use App\Interfaces\ParentChildQuestionInterface;
use App\Interfaces\PreviousQuestionAnswerInterface;
use App\Interfaces\QScoreClinicianInterface;
use App\Interfaces\QuestionnaireAnswersInterface;
use App\Interfaces\QuestionnaireInterface;
use App\Interfaces\ScoreInterface;
use App\Interfaces\UserExtraInformationInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\UserMangeRoleInterface;
use App\Interfaces\HelpDeskInterface;
use App\Repositories\CarsDetailRepositories;
use App\Repositories\CategoriesRepository;
use App\Repositories\CategoryAlgoRepository;
use App\Repositories\CImportQuestionRepository;
use App\Repositories\ClinicianRepository;
use App\Repositories\FinalPageResponseRepository;
use App\Repositories\HealthBoardRepository;
use App\Repositories\HelpDeskRepository;
use App\Repositories\ImportQuestionRepository;
use App\Repositories\InformantRepository;
use App\Repositories\ParentChildQuestionRepository;
use App\Repositories\PreviousQuestionAnswerRepository;
use App\Repositories\QScoreClinicianRepository;
use App\Repositories\QuestionnaireAnswersRepository;
use App\Repositories\QuestionnaireRepository;
use App\Repositories\ScoreRepository;
use App\Repositories\UserExtraInformationRepository;
use App\Repositories\UserMangeRoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CarsDetailInterface::class, CarsDetailRepositories::class);
        $this->app->bind(CategoriesInterface::class, CategoriesRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Enrollment;

use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment;
use App\MoonShine\Resources\Enrollment\Pages\EnrollmentIndexPage;
use App\MoonShine\Resources\Enrollment\Pages\EnrollmentFormPage;
use App\MoonShine\Resources\Enrollment\Pages\EnrollmentDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Enrollment, EnrollmentIndexPage, EnrollmentFormPage, EnrollmentDetailPage>
 */
class EnrollmentResource extends ModelResource
{
    protected string $model = Enrollment::class;

    protected string $title = 'Arizalar';
    
    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            EnrollmentIndexPage::class,
            EnrollmentFormPage::class,
            EnrollmentDetailPage::class,
        ];
    }
}

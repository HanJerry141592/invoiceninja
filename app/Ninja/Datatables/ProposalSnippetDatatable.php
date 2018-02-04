<?php

namespace App\Ninja\Datatables;

use Auth;
use URL;
use Utils;

class ProposalSnippetDatatable extends EntityDatatable
{
    public $entityType = ENTITY_PROPOSAL_SNIPPET;
    public $sortCol = 1;

    public function columns()
    {
        return [
            [
                'proposal',
                function ($model) {
                    if (! Auth::user()->can('editByOwner', [ENTITY_PROPOSAL_SNIPPET, $model->user_id])) {
                        return $model->proposal;
                    }

                    return link_to("proposals/snippets/{$model->public_id}/edit", $model->proposal)->toHtml();
                },
            ],
            [
                'category',
                function ($model) {
                    if (! Auth::user()->can('editByOwner', [ENTITY_PROPOSAL_CATEGORY, $model->category_user_id])) {
                        return $model->category;
                    }

                    return link_to("proposals/categories/{$model->category_public_id}/edit", $model->category)->toHtml();
                },
            ],
        ];
    }

    public function actions()
    {
        return [
            [
                trans('texts.edit_proposal_snippet'),
                function ($model) {
                    return URL::to("proposals/snippets/{$model->public_id}/edit");
                },
                function ($model) {
                    return Auth::user()->can('editByOwner', [ENTITY_PROPOSAL_SNIPPET, $model->user_id]);
                },
            ],
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchPanels\StoreSearchPanelRequest;
use App\Http\Requests\SearchPanels\UpdateSearchPanelRequest;
use App\Http\Resources\DBResource;
use App\Http\Resources\SearchPanelCollection;
use App\Http\Resources\SearchPanelResource;
use App\Models\SearchPanel;
use App\Repositories\Facades\SPRepo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchPanelController extends Controller
{
    public function index()
    {
        return new SearchPanelCollection(SPRepo::getAll());
    }

    public function store(StoreSearchPanelRequest $request)
    {
        $createdSearchPanel =   SPRepo::create($request->all());
        if ($createdSearchPanel === null) {
            return (new DBResource($createdSearchPanel))
                ->response()->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        $createdSearchPanel =   new SearchPanelResource($createdSearchPanel);
        return $createdSearchPanel->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SearchPanel $search_panel)
    {
        return new SearchPanelResource($search_panel);
    }

    public function update(UpdateSearchPanelRequest $request, SearchPanel $search_panel)
    {
        $updated_search_panel   =   SPRepo::update($search_panel, $request->all());
        $status = $updated_search_panel === null ? Response::HTTP_BAD_REQUEST : Response::HTTP_OK;
        return  (new DBResource($updated_search_panel))->response()->setStatusCode($status);
    }

    public function delete(SearchPanel $search_panel)
    {
        $deleted_search_panel   =   SPRepo::delete($search_panel);
        $status = $deleted_search_panel === null ? Response::HTTP_BAD_REQUEST : Response::HTTP_OK;
        return  (new DBResource($deleted_search_panel))->response()->setStatusCode($status);
    }

    public function restore($search_panel)
    {
        $restored_search_panel  =   SPRepo::restore($search_panel);
        $status = $restored_search_panel === null ? Response::HTTP_BAD_REQUEST : Response::HTTP_OK;
        return  (new DBResource($restored_search_panel))->response()->setStatusCode($status);
    }

    public function destroy($search_panel)
    {
        $destroyed_search_panel =   SPRepo::destroy($search_panel);
        $status = $destroyed_search_panel === null ? Response::HTTP_BAD_REQUEST : Response::HTTP_OK;
        return  (new DBResource($destroyed_search_panel))->response()->setStatusCode($status);
    }
}

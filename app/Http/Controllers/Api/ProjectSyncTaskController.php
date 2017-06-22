<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\IndexProjectSyncTaskRequest;
use App\Http\Transformers\Api\SyncTaskTransformer;
use App\Models\Project;

/**
 * @resource SyncTask
 *
 * @package App\Http\Controllers\Api
 */
class ProjectSyncTaskController extends ApiController
{
	/**
	 * Project sync task list
	 *
	 * You can specify a GET parameter `root` (return only root tasks if true, children only if false) to filter results.
	 *
	 * @param IndexProjectSyncTaskRequest $request
	 * @param string $projectId Project UUID
	 * @return \Dingo\Api\Http\Response
	 */
	public function index(IndexProjectSyncTaskRequest $request, $projectId)
	{
		$project = Project::authorized(['Owner', 'Administrator'])->find($projectId);

		if (!$project)
			return $this->response->errorNotFound();

		if ($request->has('root')) {
			if ($request->input('root')) {
				$paginator = $project->syncTasks()
									 ->parents()
									 ->applyRequestQueryString()
									 ->withCount('childrenSyncTasks')
									 ->withCount('syncTaskLogs')
									 ->paginate();

			} else {
				$paginator = $project->syncTasks()
									 ->children()
									 ->applyRequestQueryString()
									 ->withCount('childrenSyncTasks')
									 ->withCount('syncTaskLogs')
									 ->paginate();

			}
		} else {
			$paginator = $project->syncTasks()
								 ->applyRequestQueryString()
								 ->withCount('childrenSyncTasks')
								 ->withCount('syncTaskLogs')
								 ->paginate();
		}
		
		
		return $this->response->paginator($paginator, new SyncTaskTransformer);
	}
}

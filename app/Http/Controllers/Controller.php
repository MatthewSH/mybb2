<?php namespace MyBB\Core\Http\Controllers;

use MyBB\Auth\Contracts\Guard;
use MyBB\Core\Database\Repositories\IUserRepository;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use View;

abstract class Controller extends BaseController
{

	use DispatchesCommands, ValidatesRequests;

	public function __construct(Guard $guard)
	{
		View::share('auth_user', $guard->user());

		$guard->user()->update([
			'last_visit' => new \DateTime()
		]);
	}
}

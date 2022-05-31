<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */
  'menu' => [[
		'icon' => 'fa fa-th-large',
		'title' => 'Рабочий стол',
		'url' => '/admin'
	],[
		'icon' => 'fa fa-credit-card',
		'title' => 'Payme',
		'url' => '/admin/payme'
	],[
		'icon' => 'fas fa-money-check-alt',
		'title' => 'Click',
		'url' => '/admin/click'
	],[
      'icon' => 'fas fa-file-invoice-dollar',
      'title' => 'Платежи',
      'url' => '/admin/bills'
  ]
]
];

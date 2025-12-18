<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('pegawai', 'Pegawai::index');
$routes->post('pegawai/simpan', 'Pegawai::simpan');
$routes->get('pegawai/edit/(:num)', 'Pegawai::edit/$1');
$routes->get('pegawai/hapus/(:num)', 'Pegawai::hapus/$1');

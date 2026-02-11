<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminBackupController extends Controller
{
    public function download()
    {
        $host = Config::get('database.connections.mysql.host');
        $port = Config::get('database.connections.mysql.port', '3306');
        $database = Config::get('database.connections.mysql.database');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');

        $fileName = 'backup_' . $database . '_' . date('Y-m-d_H-i-s') . '.sql';

        // Check if mysqldump is available
        $mysqldumpPath = $this->findMysqldump();

        if (!$mysqldumpPath) {
            return back()->with('error', 'mysqldump tidak ditemukan. Pastikan MySQL terinstall dengan benar.');
        }

        $command = sprintf(
            '"%s" --host=%s --port=%s --user=%s --password=%s %s',
            $mysqldumpPath,
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            $password ? escapeshellarg($password) : '""',
            escapeshellarg($database)
        );

        $response = new StreamedResponse(function () use ($command) {
            $process = popen($command . ' 2>&1', 'r');
            if ($process) {
                while (!feof($process)) {
                    echo fread($process, 8192);
                    flush();
                }
                pclose($process);
            }
        });

        $response->headers->set('Content-Type', 'application/sql');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }

    /**
     * Try to find mysqldump executable path.
     */
    private function findMysqldump(): ?string
    {
        $paths = [
            'mysqldump', // Available in PATH
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mysql-5.7.33-winx64\\bin\\mysqldump.exe',
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
            '/usr/local/mysql/bin/mysqldump',
        ];

        foreach ($paths as $path) {
            if ($path === 'mysqldump') {
                // Check if available in system PATH
                $check = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 'where mysqldump 2>NUL' : 'which mysqldump 2>/dev/null';
                exec($check, $output, $returnCode);
                if ($returnCode === 0) {
                    return 'mysqldump';
                }
            } elseif (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }
}

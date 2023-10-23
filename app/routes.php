<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    // read pelangan
    $app->get('/pelanggan', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL BacaPelanggan()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    // create pelanggan
    $app->post('/pelanggan', function (Request $request, Response $response) {  
        $db = $this->get(PDO::class);

        $data = $request->getParsedBody();
        $nama = $data['nama'];
        $alamat = $data['alamat'];
        $email = $data['email'];
        $telp = $data['telp'];
        $query = $db->prepare('CALL TambahPelanggan(:nama_param, :alamat_param, :email_param, :telp_param)');
        $query->bindParam(':nama_param', $nama, PDO::PARAM_STR);
        $query->bindParam(':alamat_param', $alamat, PDO::PARAM_STR);
        $query->bindParam(':email_param', $email, PDO::PARAM_STR);
        $query->bindParam(':telp_param', $telp, PDO::PARAM_STR);
        $query->execute();

        $response->getBody()->write(json_encode([
            'message' => 'data pelanggan berhasil ditambahkan'
        ]));

        return $response->withHeader("Content-Type", "application/json");
    });

    // update pelanggan
    $app->put('/pelanggan/{id}', function (Request $request, Response $response, $args) {
    $db = $this->get(PDO::class);

        $data = $request->getParsedBody();
        $nama = $data['nama'];
        $alamat = $data['alamat'];
        $email = $data['email'];
        $telp = $data['telp'];

        $query = $db->prepare("CALL UpdatePelanggan(:id, :nama, :alamat, :email, :telp)");
        $query->bindParam(':id', $args['id'], PDO::PARAM_INT);
        $query->bindParam(':nama', $nama, PDO::PARAM_STR);
        $query->bindParam(':alamat', $alamat, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':telp', $telp, PDO::PARAM_STR);
        $query->execute();

        $response->getBody()->write(json_encode([
            'message' => 'data pelanggan berhasil diubah'
        ]));

        return $response->withHeader("Content-Type", "application/json");
    });

    // delete pelanggan
    $app->delete('/pelanggan/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);
        $pelangganId = $args['id'];

        try {
            $query = $db->prepare('CALL HapusPelanggan(:id)');
            $query->bindParam(':id', $pelangganId, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() === 0) {
                $response = $response->withStatus(404);
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Data tidak ditemukan'
                    ]
                ));
            } else {
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'pelanggan dengan id ' . $pelangganId . ' dihapus dari database'
                    ]
                ));
            }
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(
                [
                    'message' => 'Database error ' . $e->getMessage()
                ]
            ));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // read motor
    $app->get('/motor', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL BacaMotor()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    // create motor
    $app->post('/motor', function (Request $request, Response $response) {  
        $db = $this->get(PDO::class);

        $data = $request->getParsedBody();
        $jenis = $data['jenis'];
        $merk = $data['merk'];
        $tahun = $data['tahun'];
        $status = $data['status'];
        $harga = $data['harga'];
        $query = $db->prepare('CALL TambahMotor(:jenis_param, :merk_param, :tahun_param, :status_param, :harga_param)');
        $query->bindParam(':jenis_param', $jenis, PDO::PARAM_STR);
        $query->bindParam(':merk_param', $merk, PDO::PARAM_STR);
        $query->bindParam(':tahun_param', $tahun, PDO::PARAM_INT);
        $query->bindParam(':status_param', $status, PDO::PARAM_STR);
        $query->bindParam(':harga_param', $harga, PDO::PARAM_INT);
        $query->execute();

        $response->getBody()->write(json_encode([
            'message' => 'data motor berhasil ditambahkan'
        ]));

        return $response->withHeader("Content-Type", "application/json");
    });

    // update motor
    $app->put('/motor/{id}', function (Request $request, Response $response, $args) {
    $db = $this->get(PDO::class);

        $data = $request->getParsedBody();
        $jenis = $data['jenis'];
        $merk = $data['merk'];
        $tahun = $data['tahun'];
        $status = $data['status'];
        $harga = $data['harga'];

        $query = $db->prepare("CALL UpdateMotor(:id, :jenis, :merk, :tahun, :status, :harga)");
        $query->bindParam(':id', $args['id'], PDO::PARAM_INT);
        $query->bindParam(':jenis', $jenis, PDO::PARAM_STR);
        $query->bindParam(':merk', $merk, PDO::PARAM_STR);
        $query->bindParam(':tahun', $tahun, PDO::PARAM_INT);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':harga', $harga, PDO::PARAM_INT);
        $query->execute();

        $response->getBody()->write(json_encode([
            'message' => 'data motor berhasil diubah'
        ]));

        return $response->withHeader("Content-Type", "application/json");
    });

    // delete motor
    $app->delete('/motor/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);
        $motorId = $args['id'];

        try {
            $query = $db->prepare('CALL HapusMotor(:id)');
            $query->bindParam(':id', $motorId, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() === 0) {
                $response = $response->withStatus(404);
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Data tidak ditemukan'
                    ]
                ));
            } else {
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'motor dengan id ' . $motorId . ' dihapus dari database'
                    ]
                ));
            }
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(
                [
                    'message' => 'Database error ' . $e->getMessage()
                ]
            ));
        }

        return $response->withHeader("Content-Type", "application/json");
    });

    // read transaksi
    $app->get('/transaksi', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL BacaTransaksi()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });

    // tambah transaksi
    $app->post("/transaksi", function (Request $request, Request $response) {
        $db = $this->get(PDO::class);

        $data = $request->getParsedBody();
        $pelanggan = $data['id_pelanggan'];
        $motor = $data['id_motor'];
        $tanggalSewa = $data['tanggal_sewa'];
        $tanggalKembali = $data['tanggal_kembali'];

        $query = $db->prepare('CALL TambahTransaksi(:id_pelanggan, :id_motor, :tanggal_sewa, :tanggal_kembali)');
        $query->bindParam(':id_pelanggan', $pelanggan, PDO::PARAM_INT);
        $query->bindParam(':id_motor', $motor, PDO::PARAM_INT);
        $query->bindParam(':tanggal_sewa', $tanggalSewa, PDO::PARAM_STR);
        $query->bindParam(':tanggal_kembali', $tanggalKembali, PDO::PARAM_STR);
        $query->execute();
        $response->getBody()->write(json_encode([
            'message' => 'data transaksi berhasil ditambahkan'
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // update transaksi
    $app->put('/transaksi/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);
        $data = $request->getParsedBody();
        $transaksiId = $args['id'];
        $tanggalSewa = $data['tanggal_sewa'];
        $tanggalKembali = $data['tanggal_kembali'];

        $query = $db->prepare('CALL UpdateTransaksi(:id, :tanggal_sewa, :tanggal_kembali)');
        $query->bindParam(':id', $transaksiId, PDO::PARAM_INT);
        $query->bindParam(':tanggal_sewa', $tanggalSewa, PDO::PARAM_STR);
        $query->bindParam(':tanggal_kembali', $tanggalKembali, PDO::PARAM_STR);
        $query->execute();
        $response->getBody()->write(json_encode([
            'message' => 'data transaksi berhasil diubah'
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    });

    // hapus transaksi
    $app->delete('/transaksi/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);
        $transaksiId = $args['id'];

        try {
            $query = $db->prepare('CALL HapusTransaksi(:id)');
            $query->bindParam(':id', $transaksiId, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() === 0) {
                $response = $response->withStatus(404);
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Data tidak ditemukan'
                    ]
                ));
            } else {
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'transaksi dengan id ' . $transaksiId . ' dihapus dari database'
                    ]
                ));
            }
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(
                [
                    'message' => 'Database error ' . $e->getMessage()
                ]
            ));
        }});
        
    //read penyewaan tambahan
    $app->get('/penyewaan_tambahan', function (Request $request, Response $response) {
        $db = $this->get(PDO::class);

        $query = $db->query('CALL BacaPenyewaanTambahan()');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($results));

        return $response->withHeader("Content-Type", "application/json");
    });
    
    //create penyewaan tambahan
    $app->post('/penyewaan_tambahan', function (Request $request, Response $response) {  
        $db = $this->get(PDO::class);

        $data = $request->getParsedBody();
        $transaksi = $data['id_transaksi'];
        $detail = $data['detail'];
        $biaya = $data['biaya'];

        $query = $db->prepare('CALL TambahPenyewaanTambahan(:id_transaksi, :detail, :biaya)');
        $query->bindParam(':id_transaksi', $transaksi, PDO::PARAM_INT);
        $query->bindParam(':detail', $detail, PDO::PARAM_STR);
        $query->bindParam(':biaya', $biaya, PDO::PARAM_INT);
        $query->execute();

        $response->getBody()->write(json_encode([
            'message' => 'data penyewaan tambahan berhasil ditambahkan'
        ]));

        return $response->withHeader("Content-Type", "application/json");
    });

    //update penyewaan tambahan
    $app->put('/penyewaan_tambahan/{id}', function (Request $request, Response $response, $args) {
    $db = $this->get(PDO::class);

        $data = $request->getParsedBody();
        $detail = $data['detail'];
        $biaya = $data['biaya'];

        $query = $db->prepare("CALL UpdatePenyewaanTambahan(:id, :detail, :biaya)");
        $query->bindParam(':id', $args['id'], PDO::PARAM_INT);
        $query->bindParam(':detail', $detail, PDO::PARAM_STR);
        $query->bindParam(':biaya', $biaya, PDO::PARAM_INT);
        $query->execute();

        $response->getBody()->write(json_encode([
            'message' => 'data penyewaan tambahan berhasil diubah'
        ]));

        return $response->withHeader("Content-Type", "application/json");
    });

    //delete penyewaan tambahan
    $app->delete('/penyewaan_tambahan/{id}', function (Request $request, Response $response, $args) {
        $db = $this->get(PDO::class);
        $penyewaanTambahanId = $args['id'];

        try {
            $query = $db->prepare('CALL HapusPenyewaanTambahan(:id)');
            $query->bindParam(':id', $penyewaanTambahanId, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() === 0) {
                $response = $response->withStatus(404);
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'Data tidak ditemukan'
                    ]
                ));
            } else {
                $response->getBody()->write(json_encode(
                    [
                        'message' => 'penyewaan tambahan dengan id ' . $penyewaanTambahanId . ' dihapus dari database'
                    ]
                ));
            }
        } catch (PDOException $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(
                [
                    'message' => 'Database error ' . $e->getMessage()
                ]
            ));
        }

        return $response->withHeader("Content-Type", "application/json");
    });
};
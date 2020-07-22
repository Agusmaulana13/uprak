<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
  
  public function __construct(){
          parent::__construct();

           $this->load->model('App_model');
  }
  
  public function index(){
   
    $this->load->view('dashboard');
  }
  public function view(){
     $data['tb_pengaduan'] = $this->App_model->view();
    $this->load->view('auth/form', $data);

  }
  
  public function tambah(){
    $data = array();
    
    if($this->input->post('submit')){ // Jika user menekan tombol Submit (Simpan) pada form
      // lakukan upload file dengan memanggil function upload yang ada di App_model.php
      $upload = $this->App_model->upload();
      
      if($upload['result'] == "success"){ // Jika proses upload sukses
         // Panggil function save yang ada di App_model.php untuk menyimpan data ke database
        $this->App_model->save($upload);
        
        redirect('home/view/dashboard'); // Redirect kembali ke halaman awal / halaman view data
      }else{ // Jika proses upload gagal
        $data['message'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
      }
    }
    
    $this->load->view('auth/form', $data);
  }
  public function regis()
  {
    $this->load->view('auth/registrasi');
  }
  public function ceklogin()
  {
    if(isset($_POST['login'])){
      $email = $this->input->post('email',true);
      $pass = $this->input->post('pass',true);
      $cek = $this->App_model->proseslogin($email,$pass);
      $hasil = count((array)$cek);
      if ($hasil > 0) {
        $pelogin = $this->db->get_where('user',array('email' => $email,'password' => $pass))->row(); 
        $this->session->set_userdata($hasil);
      
    
         redirect('home/view/dashboard', $pelogin->email);
      }else{
        redirect('');
      }
    } 
  }
  public function logout(){
    $this->session->sess_destroy();
    redirect(site_url(''));
  }
  public function beranda(){
    $this->load->view('auth/form');
    
  }
  public function insert(){
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $data = array('nik' => $nik, 'nama' => $nama,'email' => $email,'password' => $password,'telp' => $phone,);
    $tambah = $this->App_model->tambahData('user',$data);
    if($tambah > 0){
      redirect('');
    }else{
      echo "gagal";
    }
  }


  
  public function admin(){
    $this->load->view('admin/login');

    if(isset($_POST['login'])){
      $email = $this->input->post('email',true);
      $pass = $this->input->post('pass',true);
      $cek = $this->App_model->prologin($email,$pass);
      $hasil = count((array)$cek);
      if($hasil > 0){
        $datalogin = $this->db->get_where('petugas', array('email' => $email, 'password' => $pass))->row();
        if($datalogin->level == 'admin'){
           redirect('home/dashadmin');
        }elseif($datalogin->level == 'petugas') {
          redirect('home/dashpetugas');
        }
        
      }
    }
  }

    public function dashadmin(){
    $this->data['hasil'] = $this->App_model->getUser('user');
    $this->data['result'] = $this->App_model->getPetugas('petugas');
    $this->data['gambar'] = $this->App_model->view('gambar');
    $this->data['tanggapan'] = $this->App_model->getTanggapan('tanggapan');
  
    $this->load->view('admin/dashboard', $this->data);
  }
  public function dashpetugas(){
    $this->load->view('admin/petugas');
  }

  public function delete($id){
    $hapus= $this->App_model->hapusData('user',$id);
    if($hapus > 0){
      redirect('homr/dashadmin');
    }else{
      echo "gagal";
    }
  }

  public function hapus($id){
    $hapus= $this->App_model->hapus('petugas',$id);
    if($hapus > 0){
      redirect('home/dashadmin');
    }else{
      echo "gagal";
    }
  }
  public function hapusPengadu($id){
    $hapus= $this->App_model->hapusPengadu('tb_pengaduan',$id);
    if($hapus > 0){
      redirect('home/dashadmin');
    }else{
      echo "gagal";
    }
  }
 public function form_edit($id){

    $this->data['dataEdit'] = $this->App_model->dataEdit('tb_pengaduan',$id);
    $this->load->view('form/form-edit', $this->data);
  }
  public function update($id){
    $status = $_POST['status'];
    
    $data = array('status' => $status, );
    $edit = $this->App_model->editData('tb_pengaduan',$data,$id);
    if($edit > 0){
      redirect('home/dashadmin');
    }else{
      echo "gagal";
    }
  } 

  public function print(){
    $data['laporan'] = $this->App_model->view("tb_pengaduan");
    $this->load->view('form/print_laporan', $data);
  }    
}

<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin_crud extends CI_Model
{
    // Adding a new slide
    public function add_slide()
    {
        $ext = pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $data['image_name'] = $this->input->post('image_name');
            $data['image_link'] = $_FILES['image_link']['name'];
            $data['status'] = 'Show';
            $data['timestamp'] = time();

            $this->db->insert('slide', $data);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/slides/' . $data['image_link']);

            $this->load->library('image_lib');

            $img_cfg['image_library'] = 'gd2';
            $img_cfg['source_image'] = './uploads/slides/' . $data['image_link'];
            $img_cfg['maintain_ratio'] = false;
            $img_cfg['create_thumb'] = false;
            $img_cfg['new_image'] = './uploads/slides/' . $data['image_link'];
            $img_cfg['width'] = 555;
            $img_cfg['height'] = 320;
            $img_cfg['quality'] = 100;

            $this->image_lib->clear();
            $this->image_lib->initialize($img_cfg);
            $this->image_lib->resize();

            $this->session->set_flashdata('success', $this->lang->line('slide_added'));

            redirect(base_url() . 'admin/slides', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('slide_not_added'));

            redirect(base_url() . 'admin/slides', 'refresh');
        }
    }

    // Editing a slide
    public function edit_slide($param = '')
    {
        $data['image_name'] = $this->input->post('image_name');
        $data['status'] = $this->input->post('status');

        $this->db->where('slide_id', $param);
        $this->db->update('slide', $data);

        $this->session->set_flashdata('success', $this->lang->line('slide_updated'));

        redirect(base_url() . 'admin/slides', 'refresh');
    }

    // Editing a slide image
    public function change_slide_image($param = '')
    {
        $ext = pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $image_link = $this->db->get_where('slide', array(
                'slide_id' => $param,
            ))->row()->image_link;
            if (isset($image_link)) {
                unlink('uploads/slides/' . $image_link);
            }

            $data['image_link'] = $_FILES['image_link']['name'];

            $this->db->where('slide_id', $param);
            $this->db->update('slide', $data);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/slides/' . $data['image_link']);

            $this->load->library('image_lib');

            $img_cfg['image_library'] = 'gd2';
            $img_cfg['source_image'] = './uploads/slides/' . $data['image_link'];
            $img_cfg['maintain_ratio'] = false;
            $img_cfg['create_thumb'] = false;
            $img_cfg['new_image'] = './uploads/slides/' . $data['image_link'];
            $img_cfg['width'] = 555;
            $img_cfg['height'] = 320;
            $img_cfg['quality'] = 100;

            $this->image_lib->clear();
            $this->image_lib->initialize($img_cfg);
            $this->image_lib->resize();

            $this->session->set_flashdata('success', $this->lang->line('slide_changed'));

            redirect(base_url() . 'admin/slides', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('slide_not_added'));

            redirect(base_url() . 'admin/slides', 'refresh');
        }
    }

    // Deleting a slide
    public function delete_slide($param = '')
    {
        $image_link = $this->db->get_where('slide', array(
            'slide_id' => $param,
        ))->row()->image_link;
        if (isset($image_link)) {
            unlink('uploads/slides/' . $image_link);
        }

        $this->db->where('slide_id', $param);
        $this->db->delete('slide');

        $this->session->set_flashdata('success', $this->lang->line('slide_deleted'));

        redirect(base_url() . 'admin/slides', 'refresh');
    }

    // Updating about us text
    public function update_about_us_text()
    {
        $data['title'] = $this->input->post('title', true);
        $data['tagline'] = $this->input->post('tagline', true);
        $data['description'] = $this->input->post('description', true);

        $this->db->where('about_us_id', '1');
        $this->db->update('about_us', $data);

        $this->session->set_flashdata('success', $this->lang->line('about_us_text'));
        $this->session->set_flashdata('about_us_text', '1');

        redirect(base_url() . 'admin/about_us', 'refresh');
    }

    // Updating about us image
    public function update_about_us_image()
    {
        $ext = pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $image_link = $this->db->get_where('about_us', array(
                'about_us_id' => '1',
            ))->row()->image_link;
            if (isset($image_link)) {
                unlink('uploads/about_us/' . $image_link);
            }

            $data['image_link'] = $_FILES['image_link']['name'];

            $this->db->where('about_us_id', '1');
            $this->db->update('about_us', $data);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/about_us/' . $data['image_link']);

            $this->load->library('image_lib');

            $img_cfg['image_library'] = 'gd2';
            $img_cfg['source_image'] = './uploads/about_us/' . $data['image_link'];
            $img_cfg['maintain_ratio'] = false;
            $img_cfg['create_thumb'] = false;
            $img_cfg['new_image'] = './uploads/about_us/' . $data['image_link'];
            $img_cfg['width'] = 360;
            $img_cfg['height'] = 118;
            $img_cfg['quality'] = 100;

            $this->image_lib->clear();
            $this->image_lib->initialize($img_cfg);
            $this->image_lib->resize();

            $this->session->set_flashdata('success', $this->lang->line('about_us_image'));
            $this->session->set_flashdata('about_us_image');

            redirect(base_url() . 'admin/about_us', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('about_us_no_image'));
            $this->session->set_flashdata('about_us_image', '1');

            redirect(base_url() . 'admin/about_us', 'refresh');
        }
    }

    public function update_terms_and_conditions()
    {
        $data['terms_and_conditions'] = $this->input->post('terms_and_conditions');

        $this->db->where('about_us_id', '1');
        $this->db->update('about_us', $data);

        $this->session->set_flashdata('tc_success', $this->lang->line('tc_success'));

        redirect(base_url() . 'admin/about_us', 'refresh');
    }

    // Adding a new alumnus
    public function add_alumnus()
    {
        $ext = pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $alumni = $this->db->get('alumnus')->result_array();
            foreach ($alumni as $alumnus) {
                if ($alumnus['email'] == $this->input->post('email')) {
                    $this->session->set_flashdata('warning', $this->input->post('email') . ' ' . $this->lang->line('email_already_in_use'));

                    redirect(base_url() . 'admin/add_alumnus', 'refresh');
                } else if ($alumnus['username'] == preg_replace('/\s+/', '-', $this->input->post('username'))) {
                    $this->session->set_flashdata('warning', $this->input->post('username') . ' ' . $this->lang->line('alumnus_username'));

                    redirect(base_url() . 'admin/add_alumnus', 'refresh');
                }
            }

            $data['name'] = $this->input->post('name');
            $data['username'] = preg_replace('/\s+/', '-', $this->input->post('username'));
            $data['email'] = $this->input->post('email');
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $data['mobile_number'] = $this->input->post('mobile_number');
            $data['location_id'] = $this->input->post('location_id');
            $data['website'] = $this->input->post('website');
            $data['dob'] = strtotime($this->input->post('dob'));
            $data['batch'] = $this->input->post('batch');
            $data['image_link'] = $_FILES['image_link']['name'];
            $data['position'] = $this->input->post('position');
            $data['profession_id'] = $this->input->post('profession_id');
            $data['short_bio'] = $this->input->post('short_bio');
            $data['blood_group'] = $this->input->post('blood_group');
            $data['facebook'] = $this->input->post('facebook');
            $data['twitter'] = $this->input->post('twitter');
            $data['linkedin'] = $this->input->post('linkedin');
            $data['documents']      = $this->input->post('documents');
            // $data['documents'] = $_FILES['documents']['name'];
            $data['youtube'] = $this->input->post('youtube');
            $data['status'] = $this->input->post('status');
            $data['deceased'] = $this->input->post('deceased');
            $data['step'] = 1;
            $data['timestamp'] = time();

            $this->db->insert('alumnus', $data);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/alumni/' . $data['image_link']);

            $this->load->library('image_lib');

            $img_cfg['image_library'] = 'gd2';
            $img_cfg['source_image'] = './uploads/alumni/' . $data['image_link'];
            $img_cfg['maintain_ratio'] = false;
            $img_cfg['create_thumb'] = false;
            $img_cfg['new_image'] = './uploads/alumni/' . $data['image_link'];
            $img_cfg['width'] = 160;
            $img_cfg['height'] = 160;
            $img_cfg['quality'] = 100;

            $this->image_lib->clear();
            $this->image_lib->initialize($img_cfg);
            $this->image_lib->resize();

            $this->session->set_flashdata('success', $this->lang->line('alumnus_added'));

            $message = $this->lang->line('add_alumnus_email_1') . ' ' . $data['email'] . '<br>' . $this->lang->line('add_alumnus_email_2') . ' ' . $this->input->post('password') . '<br><br>' . $this->lang->line('add_alumnus_email_3');

            $this->email_crud->send_email($this->db->get_where('about_us', array(
                'about_us_id' => 1,
            ))->row()->title . ' ' . $this->lang->line('alumnus_email'), 'alumnus', $data['email'], $message, $data['name']);

            redirect(base_url() . 'admin/alumni', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('not_image'));

            redirect(base_url() . 'admin/alumni', 'refresh');
        }
    }

    // Editing a alumnus
    public function edit_alumnus($param = '')
    {
        $db_email = $this->db->get_where('alumnus', array('alumnus_id' => $param))->row()->email;
        $db_username = $this->db->get_where('alumnus', array('alumnus_id' => $param))->row()->username;

        if ($db_email != $this->input->post('email')) {
            $alumni = $this->db->get('alumnus')->result_array();
            foreach ($alumni as $alumnus) {
                if ($alumnus['email'] == $this->input->post('email')) {
                    $this->session->set_flashdata('warning', $this->input->post('email') . ' ' . $this->lang->line('email_already_in_use'));

                    redirect(base_url() . 'admin/alumni', 'refresh');
                }
            }
        } else if ($db_username != $this->input->post('username')) {
            $alumni = $this->db->get('alumnus')->result_array();
            foreach ($alumni as $alumnus) {
                if ($alumnus['username'] == preg_replace('/\s+/', '-', $this->input->post('username'))) {
                    $this->session->set_flashdata('warning', $this->input->post('username') . ' ' . $this->lang->line('alumnus_username'));

                    redirect(base_url() . 'admin/alumni', 'refresh');
                }
            }
        }

        $data['name'] = $this->input->post('name');
        $data['username'] = preg_replace('/\s+/', '-', $this->input->post('username'));
        $data['email'] = $this->input->post('email');
        if ($this->db->get_where('alumnus', array('alumnus_id' => $param))->row()->password == "") {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }
        $data['mobile_number'] = $this->input->post('mobile_number');
        $data['location_id'] = $this->input->post('location_id');
        $data['website'] = $this->input->post('website');
        $data['dob'] = strtotime($this->input->post('dob'));
        $data['batch'] = $this->input->post('batch');
        $data['position'] = $this->input->post('position');
        $data['profession_id'] = $this->input->post('profession_id');
        $data['short_bio'] = $this->input->post('short_bio');
        $data['blood_group'] = $this->input->post('blood_group');
        $data['facebook'] = $this->input->post('facebook');
        $data['twitter'] = $this->input->post('twitter');
        $data['linkedin'] = $this->input->post('linkedin');
        $data['documents'] = $this->input->post('documents');
        $data['youtube'] = $this->input->post('youtube');
        $data['status'] = $this->input->post('status');
        $data['deceased'] = $this->input->post('deceased');
        $data['step'] = 1;

        if ($this->db->get_where('alumnus', array('alumnus_id' => $param))->row()->password == "") {
            $message = $this->lang->line('add_alumnus_email_1') . ' ' . $data['email'] . '<br>' . $this->lang->line('add_alumnus_email_2') . ' ' . $this->input->post('password') . '<br><br>' . $this->lang->line('add_alumnus_email_3');

            $this->email_crud->send_email($this->db->get_where('about_us', array(
                'about_us_id' => 1,
            ))->row()->title . ' ' . $this->lang->line('alumnus_email'), 'alumnus', $data['email'], $message, $data['name']);
        }

        $this->db->where('alumnus_id', $param);
        $this->db->update('alumnus', $data);

        $this->session->set_flashdata('success', $this->lang->line('alumnus_updated'));

        redirect(base_url() . 'admin/alumni', 'refresh');
    }

    // Editing an alumnus image
    public function change_alumnus_image($param = '')
    {
        $ext = pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $image_link = $this->db->get_where('alumnus', array(
                'alumnus_id' => $param,
            ))->row()->image_link;
            if (isset($image_link)) {
                unlink('uploads/alumni/' . $image_link);
            }

            $data['image_link'] = $_FILES['image_link']['name'];

            $this->db->where('alumnus_id', $param);
            $this->db->update('alumnus', $data);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/alumni/' . $data['image_link']);

            $this->load->library('image_lib');

            $img_cfg['image_library'] = 'gd2';
            $img_cfg['source_image'] = './uploads/alumni/' . $data['image_link'];
            $img_cfg['maintain_ratio'] = false;
            $img_cfg['create_thumb'] = false;
            $img_cfg['new_image'] = './uploads/alumni/' . $data['image_link'];
            $img_cfg['width'] = 160;
            $img_cfg['height'] = 160;
            $img_cfg['quality'] = 100;

            $this->image_lib->clear();
            $this->image_lib->initialize($img_cfg);
            $this->image_lib->resize();

            $this->session->set_flashdata('success', $this->lang->line('alumnus_image_changed'));

            redirect(base_url() . 'admin/alumni', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('not_image'));

            redirect(base_url() . 'admin/alumni', 'refresh');
        }
    }

    // Deleting an alumnus
    public function delete_alumnus($param = '')
    {
        $image_link = $this->db->get_where('alumnus', array(
            'alumnus_id' => $param,
        ))->row()->image_link;
        if (isset($image_link)) {
            unlink('uploads/alumni/' . $image_link);
        }

        $this->db->where('alumnus_id', $param);
        $this->db->delete('alumnus');

        $this->session->set_flashdata('success', $this->lang->line('alumnus_deleted'));

        redirect(base_url() . 'admin/alumni', 'refresh');
    }

    // Emailing all alumni
    public function email_alumni()
    {
        $alumni = $this->db->get_where('alumnus', array(
            'status' => 1,
        ))->result_array();

        $subject = $this->input->post('subject');
        $message = $this->input->post('message');

        foreach ($alumni as $alumnus) {
            $this->email_crud->send_email($this->db->get_where('about_us', array(
                'about_us_id' => 1,
            ))->row()->title . ' ' . $this->lang->line('alumnus_email') . ' - ' . $subject, 'alumnus', $alumnus['email'], $message, $alumnus['name']);
        }

        $this->session->set_flashdata('success', $this->lang->line('email_alumni'));

        redirect(base_url() . 'admin/alumni', 'refresh');
    }

    // Emailing all alumni
    public function email_alumni_class()
    {
        $alumni = $this->db->get_where('alumnus', array('status' => 1, 'batch' => $this->input->post('batch')))->result_array();

        $subject = $this->input->post('subject');
        $message = $this->input->post('message');

        foreach ($alumni as $alumnus) {
            $this->email_crud->send_email($this->db->get_where('about_us', array(
                'about_us_id' => 1,
            ))->row()->title . ' ' . $this->lang->line('alumnus_email') . ' - ' . $subject, 'alumnus', $alumnus['email'], $message, $alumnus['name']);
        }

        $this->session->set_flashdata('success', $this->lang->line('email_alumni'));

        redirect(base_url() . 'admin/alumni', 'refresh');
    }

    // Adding a new event
    public function add_event()
    {
        $ext = pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $events = $this->db->get('event')->result_array();
            foreach ($events as $event) {
                if ($event['permalink'] == $this->input->post('permalink')) {
                    $this->session->set_flashdata('warning', $this->input->post('permalink') . ' ' . $this->lang->line('event_permalink'));

                    redirect(base_url() . 'admin/add_event', 'refresh');
                }
            }

            $data['name'] = $this->input->post('name');
            $data['permalink'] = preg_replace('/\s+/', '_', $this->input->post('permalink'));
            $data['event_date'] = strtotime($this->input->post('event_date'));
            $data['event_time'] = $this->input->post('event_time');
            $data['venue'] = $this->input->post('venue');
            $data['paragraph_1'] = $this->input->post('paragraph_1');
            $data['paragraph_2'] = $this->input->post('paragraph_2');
            $data['paragraph_3'] = $this->input->post('paragraph_3');
            $data['google_map'] = $this->input->post('google_map');
            $data['image_link'] = $_FILES['image_link']['name'];
            $data['hashtag'] = $this->input->post('hashtag');
            $data['timestamp'] = time();

            $this->db->insert('event', $data);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/events/' . $data['image_link']);

            $this->load->library('image_lib');

            $img_cfg['image_library'] = 'gd2';
            $img_cfg['source_image'] = './uploads/events/' . $data['image_link'];
            $img_cfg['maintain_ratio'] = false;
            $img_cfg['create_thumb'] = false;
            $img_cfg['new_image'] = './uploads/events/' . $data['image_link'];
            $img_cfg['width'] = 236;
            $img_cfg['height'] = 236;
            $img_cfg['quality'] = 100;

            $this->image_lib->clear();
            $this->image_lib->initialize($img_cfg);
            $this->image_lib->resize();

            $data2['event_id'] = $this->db->insert_id();
            $data2['yes'] = 0;
            $data2['no'] = 0;
            $data2['maybe'] = 0;
            $data2['timestamp'] = $data['timestamp'];

            $this->db->insert('event_management', $data2);

            $this->session->set_flashdata('success', $this->lang->line('event_added'));

            redirect(base_url() . 'admin/events', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('not_image'));

            redirect(base_url() . 'admin/events', 'refresh');
        }
    }

    // Editing an event
    public function edit_event($param = '')
    {
        $data['name'] = $this->input->post('name');
        $data['permalink'] = preg_replace('/\s+/', '_', $this->input->post('permalink'));
        $data['event_date'] = strtotime($this->input->post('event_date'));
        $data['event_time'] = $this->input->post('event_time');
        $data['venue'] = $this->input->post('venue');
        $data['paragraph_1'] = $this->input->post('paragraph_1');
        $data['paragraph_2'] = $this->input->post('paragraph_2');
        $data['paragraph_3'] = $this->input->post('paragraph_3');
        $data['google_map'] = $this->input->post('google_map');
        $data['hashtag'] = $this->input->post('hashtag');

        $this->db->where('event_id', $param);
        $this->db->update('event', $data);

        $this->session->set_flashdata('success', $this->lang->line('event_updated'));

        redirect(base_url() . 'admin/events', 'refresh');
    }

    // Editing an event image
    public function change_event_image($param = '')
    {
        $ext = pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $image_link = $this->db->get_where('event', array(
                'event_id' => $param,
            ))->row()->image_link;
            if (isset($image_link)) {
                unlink('uploads/events/' . $image_link);
            }

            $data['image_link'] = $_FILES['image_link']['name'];

            $this->db->where('event_id', $param);
            $this->db->update('event', $data);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/events/' . $data['image_link']);

            $this->load->library('image_lib');

            $img_cfg['image_library'] = 'gd2';
            $img_cfg['source_image'] = './uploads/events/' . $data['image_link'];
            $img_cfg['maintain_ratio'] = false;
            $img_cfg['create_thumb'] = false;
            $img_cfg['new_image'] = './uploads/events/' . $data['image_link'];
            $img_cfg['width'] = 236;
            $img_cfg['height'] = 236;
            $img_cfg['quality'] = 100;

            $this->image_lib->clear();
            $this->image_lib->initialize($img_cfg);
            $this->image_lib->resize();

            $this->session->set_flashdata('success', $this->lang->line('event_image_changed'));

            redirect(base_url() . 'admin/events', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('not_image'));

            redirect(base_url() . 'admin/events', 'refresh');
        }
    }

    // Managing an event
    public function edit_event_managment($param = '')
    {
        $volunteers = $this->input->post('volunteers');

        $all_volunteers = '';

        if (isset($volunteers)) {
            foreach ($volunteers as $key => $value) {
                $all_volunteers .= $value . ',';
            }
        }

        $data['volunteers'] = substr(trim($all_volunteers), 0, -1);

        $this->db->where('event_management_id', $param);
        $this->db->update('event_management', $data);

        $this->session->set_flashdata('success', $this->lang->line('event_managed'));

        redirect(base_url() . 'admin/manage_events', 'refresh');
    }

    // Deleting an event
    public function delete_event($param = '')
    {
        $image_link = $this->db->get_where('event', array(
            'event_id' => $param,
        ))->row()->image_link;
        if ($image_link) {
            unlink('uploads/events/' . $image_link);
        }

        $this->db->delete('event', array(
            'event_id' => $param,
        ));
        $this->db->delete('event_management', array(
            'event_id' => $param,
        ));

        $this->session->set_flashdata('success', $this->lang->line('event_deleted'));

        redirect(base_url() . 'admin/events', 'refresh');
    }

    // Adding a new story
    public function add_story()
    {
        $ext = pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $stories = $this->db->get('story')->result_array();
            foreach ($stories as $story) {
                if ($story['permalink'] == $this->input->post('permalink')) {
                    $this->session->set_flashdata('warning', $this->input->post('permalink') . ' ' . $this->lang->line('story_permanlink'));

                    redirect(base_url() . 'admin/add_story', 'refresh');
                }
            }

            $data['title'] = $this->input->post('title');
            $data['permalink'] = preg_replace('/\s+/', '_', $this->input->post('permalink'));
            $data['image_link'] = $_FILES['image_link']['name'];
            $data['written_by'] = $this->input->post('written_by');
            $data['paragraph_1'] = $this->input->post('paragraph_1');
            $data['paragraph_2'] = $this->input->post('paragraph_2');
            $data['paragraph_3'] = $this->input->post('paragraph_3');
            $data['month'] = date('F', time());
            $data['year'] = date('Y', time());
            $data['timestamp'] = time();
            $data['user_type'] = $this->session->userdata('auth_kind');
            $data['created_by'] = $this->session->userdata('admin_id');

            $this->db->insert('story', $data);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/stories/' . $data['image_link']);

            $this->load->library('image_lib');

            $img_cfg['image_library'] = 'gd2';
            $img_cfg['source_image'] = './uploads/stories/' . $data['image_link'];
            $img_cfg['maintain_ratio'] = false;
            $img_cfg['create_thumb'] = false;
            $img_cfg['new_image'] = './uploads/stories/' . $data['image_link'];
            $img_cfg['width'] = 750;
            $img_cfg['height'] = 350;
            $img_cfg['quality'] = 100;

            $this->image_lib->clear();
            $this->image_lib->initialize($img_cfg);
            $this->image_lib->resize();

            $this->session->set_flashdata('success', $this->lang->line('story_added'));

            redirect(base_url() . 'admin/stories', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('not_image'));

            redirect(base_url() . 'admin/stories', 'refresh');
        }
    }

    // Editing a story
    public function edit_story($param = '')
    {
        $data['title'] = $this->input->post('title');
        $data['permalink'] = preg_replace('/\s+/', '_', $this->input->post('permalink'));
        $data['written_by'] = $this->input->post('written_by');
        $data['paragraph_1'] = $this->input->post('paragraph_1');
        $data['paragraph_2'] = $this->input->post('paragraph_2');
        $data['paragraph_3'] = $this->input->post('paragraph_3');

        $this->db->where('story_id', $param);
        $this->db->update('story', $data);

        $this->session->set_flashdata('success', $this->lang->line('story_updated'));

        redirect(base_url() . 'admin/stories', 'refresh');
    }

    // Editing a story image
    public function change_story_image($param = '')
    {
        $ext = pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $image_link = $this->db->get_where('story', array(
                'story_id' => $param,
            ))->row()->image_link;
            if (isset($image_link)) {
                unlink('uploads/stories/' . $image_link);
            }

            $data['image_link'] = $_FILES['image_link']['name'];

            $this->db->where('story_id', $param);
            $this->db->update('story', $data);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/stories/' . $data['image_link']);

            $this->load->library('image_lib');

            $img_cfg['image_library'] = 'gd2';
            $img_cfg['source_image'] = './uploads/stories/' . $data['image_link'];
            $img_cfg['maintain_ratio'] = false;
            $img_cfg['create_thumb'] = false;
            $img_cfg['new_image'] = './uploads/stories/' . $data['image_link'];
            $img_cfg['width'] = 750;
            $img_cfg['height'] = 350;
            $img_cfg['quality'] = 100;

            $this->image_lib->clear();
            $this->image_lib->initialize($img_cfg);
            $this->image_lib->resize();

            $this->session->set_flashdata('success', $this->lang->line('story_image_changed'));

            redirect(base_url() . 'admin/stories', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('not_image'));

            redirect(base_url() . 'admin/stories', 'refresh');
        }
    }

    // Deleting a story
    public function delete_story($param = '')
    {
        $image_link = $this->db->get_where('story', array(
            'story_id' => $param,
        ))->row()->image_link;
        if (isset($image_link)) {
            unlink('uploads/stories/' . $image_link);
        }

        $this->db->where('story_id', $param);
        $this->db->delete('story');

        $this->session->set_flashdata('success', $this->lang->line('story_deleted'));

        redirect(base_url() . 'admin/stories', 'refresh');
    }

    public function edit_permission_request($permission_request_id = '')
    {
        $data['story_permission'] = $this->input->post('story_permission', true);

        $alumnus_id = $this->db->get_where('permission_request', array('permission_request_id' => $permission_request_id))->row()->person_id;

        $this->db->where('alumnus_id', $alumnus_id);
        $this->db->update('alumnus', $data);

        $query = $this->db->get_where('admin', array('email' => $this->db->get_where('alumnus', array('alumnus_id' => $alumnus_id))->row()->email));

        if ($data['story_permission'] && $query->num_rows() == 0) {
            $admin['email'] = $this->db->get_where('alumnus', array('alumnus_id' => $alumnus_id))->row()->email;
            $admin['password'] = $this->db->get_where('alumnus', array('alumnus_id' => $alumnus_id))->row()->password;
            $admin['timestamp'] = time();
            $admin['admin_type'] = 'alumnus';
            $admin['person_id'] = $alumnus_id;

            $this->db->insert('admin', $admin);
        }

        $this->session->set_flashdata('success', $this->lang->line('permission_request_updated'));

        redirect(base_url() . 'admin/permission_requests', 'refresh');
    }

    public function delete_permission_request($permission_request_id = '')
    {
        $this->db->where('permission_request_id', $permission_request_id);
        $this->db->delete('permission_request');

        $this->session->set_flashdata('success', $this->lang->line('permission_request_deleted'));

        redirect(base_url() . 'admin/permission_requests', 'refresh');
    }

    // Changing status of a comment; 0 = pending, 1 = approved, 2 = rejected;
    public function edit_comment($param = '')
    {
        $data['status'] = $this->input->post('status');

        $this->db->where('comment_id', $param);
        $this->db->update('comment', $data);

        $this->session->set_flashdata('success', $this->lang->line('comment_updated'));

        redirect(base_url() . 'admin/comment', 'refresh');
    }

    // Adding a new album
    public function add_album()
    {
        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $data['timestamp'] = time();

        $this->db->insert('album', $data);

        $this->session->set_flashdata('success', $this->lang->line('album_added'));

        redirect(base_url() . 'admin/add_gallery/' . $this->db->insert_id(), 'refresh');
    }

    // Editing an album
    public function edit_album($param = '')
    {
        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');

        $this->db->where('album_id', $param);
        $this->db->update('album', $data);

        $this->session->set_flashdata('success', $this->lang->line('album_updated'));

        redirect(base_url() . 'admin/albums', 'refresh');
    }

    // Deleting an album
    public function delete_album($param = '')
    {
        // Deleting all photos from gallery having this album id
        $album_photos_info = $this->db->get_where('gallery', array(
            'album_id' => $param,
        ))->result_array();
        foreach ($album_photos_info as $photo_info) {
            if (isset($photo_info['image_link'])) {
                unlink('uploads/gallery/' . $photo_info['image_link']);
            }

            if (isset($photo_info['image_link'])) {
                unlink('uploads/gallery/' . 'thumb_' . $photo_info['image_link']);
            }

            $this->db->where('gallery_id', $photo_info['gallery_id']);
            $this->db->delete('gallery');
        }

        $this->db->where('album_id', $param);
        $this->db->delete('album');

        $this->session->set_flashdata('success', $this->lang->line('album_deleted'));

        redirect(base_url() . 'admin/albums', 'refresh');
    }

    // Adding photos to gallery
    public function add_gallery($album_id = '')
    {
        $ext = pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $data['image_link'] = $_FILES['image_link']['name'];
            $data['album_id'] = $album_id;
            $data['timestamp'] = time();

            $this->db->insert('gallery', $data);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/gallery/' . $data['image_link']);

            $this->load->library('image_lib');

            $img_cfg['image_library'] = 'gd2';
            $img_cfg['source_image'] = './uploads/gallery/' . $data['image_link'];
            $img_cfg['maintain_ratio'] = false;
            $img_cfg['create_thumb'] = false;
            $img_cfg['new_image'] = './uploads/gallery/' . 'thumb_' . $data['image_link'];
            $img_cfg['width'] = 100;
            $img_cfg['height'] = 100;
            $img_cfg['quality'] = 100;

            $this->image_lib->clear();
            $this->image_lib->initialize($img_cfg);
            $this->image_lib->resize();

            $this->session->set_flashdata('success', $this->lang->line('gallery_added'));

            redirect(base_url() . 'admin/add_gallery/' . $album_id, 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('not_image'));

            redirect(base_url() . 'admin/add_gallery/' . $album_id, 'refresh');
        }
    }

    // Editing photo of gallery
    public function edit_gallery($album_id = '')
    {
        $ext = pathinfo($_FILES['image_link']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $data['image_link'] = $_FILES['image_link']['name'];
            $data['album_id'] = $album_id;
            $data['timestamp'] = time();

            $this->db->insert('gallery', $data);

            move_uploaded_file($_FILES['image_link']['tmp_name'], 'uploads/gallery/' . $data['image_link']);

            $this->load->library('image_lib');

            $img_cfg['image_library'] = 'gd2';
            $img_cfg['source_image'] = './uploads/gallery/' . $data['image_link'];
            $img_cfg['maintain_ratio'] = false;
            $img_cfg['create_thumb'] = false;
            $img_cfg['new_image'] = './uploads/gallery/' . 'thumb_' . $data['image_link'];
            $img_cfg['width'] = 100;
            $img_cfg['height'] = 100;
            $img_cfg['quality'] = 100;

            $this->image_lib->clear();
            $this->image_lib->initialize($img_cfg);
            $this->image_lib->resize();

            $this->session->set_flashdata('success', $this->lang->line('gallery_updated'));

            redirect(base_url() . 'admin/edit_gallery/upload/' . $album_id, 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('not_image'));

            redirect(base_url() . 'admin/edit_gallery/upload/' . $album_id, 'refresh');
        }
    }

    // Deleting photo of gallery
    public function delete_gallery($param = '')
    {
        $album_id = $this->db->get_where('gallery', array(
            'gallery_id' => $param,
        ))->row()->album_id;
        $image_link = $this->db->get_where('gallery', array(
            'gallery_id' => $param,
        ))->row()->image_link;

        if (isset($image_link)) {
            unlink('uploads/gallery/' . $image_link);
        }

        if (isset($image_link)) {
            unlink('uploads/gallery/' . 'thumb_' . $image_link);
        }

        $this->db->where('gallery_id', $param);
        $this->db->delete('gallery');

        $this->session->set_flashdata('success', $this->lang->line('gallery_deleted'));

        redirect(base_url() . 'admin/edit_gallery/upload/' . $album_id, 'refresh');
    }

    // Adding a volunteer
    public function add_volunteer()
    {
        $volunteers = $this->db->get('volunteer')->result_array();
        foreach ($volunteers as $volunteer) {
            if ($volunteer['email'] == $this->input->post('email')) {
                $this->session->set_flashdata('warning', $this->input->post('email') . ' ' . $this->lang->line('email_already_in_use'));

                redirect(base_url() . 'admin/add_alumnus', 'refresh');
            } else if ($volunteer['username'] == preg_replace('/\s+/', '-', $this->input->post('username'))) {
                $this->session->set_flashdata('warning', $this->input->post('username') . ' ' . $this->lang->line('volunteer_username'));

                redirect(base_url() . 'admin/add_volunteer', 'refresh');
            }
        }

        $data['name'] = $this->input->post('name');
        $data['username'] = preg_replace('/\s+/', '-', $this->input->post('username'));
        $data['email'] = $this->input->post('email');
        $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $data['mobile'] = $this->input->post('mobile');
        $data['batch'] = $this->input->post('batch');
        $data['profession_id'] = $this->input->post('profession_id');
        $data['status'] = $this->input->post('status');
        $data['step'] = 1;
        $data['timestamp'] = time();

        $this->db->insert('volunteer', $data);

        $this->session->set_flashdata('success', $this->lang->line('volunteer_added'));

        $message = $this->lang->line('add_volunteer_email_1') . ' ' . $data['email'] . '<br>' . $this->lang->line('add_volunteer_email_2') . ' ' . $this->input->post('password') . '<br><br>' . $this->lang->line('add_volunteer_email_3');

        $this->email_crud->send_email($this->db->get_where('about_us', array(
            'about_us_id' => 1,
        ))->row()->title . ' ' . $this->lang->line('volunteer_email'), 'volunteer', $data['email'], $message, $data['name']);

        redirect(base_url() . 'admin/volunteers', 'refresh');
    }

    // Editing a volunteer
    public function edit_volunteer($param = '')
    {
        $db_email = $this->db->get_where('volunteer', array('volunteer_id' => $param))->row()->email;
        $db_username = $this->db->get_where('volunteer', array('volunteer_id' => $param))->row()->username;

        if ($db_email != $this->input->post('email')) {
            $volunteers = $this->db->get('volunteer')->result_array();
            foreach ($volunteers as $volunteer) {
                if ($volunteer['email'] == $this->input->post('email')) {
                    $this->session->set_flashdata('warning', $this->input->post('email') . ' ' . $this->lang->line('email_already_in_use'));

                    redirect(base_url() . 'admin/volunteers', 'refresh');
                }
            }
        } else if ($db_username != $this->input->post('username')) {
            $volunteers = $this->db->get('volunteer')->result_array();
            foreach ($volunteers as $volunteer) {
                if ($volunteer['username'] == preg_replace('/\s+/', '-', $this->input->post('username'))) {
                    $this->session->set_flashdata('warning', $this->input->post('username') . ' ' . $this->lang->line('volunteer_username'));

                    redirect(base_url() . 'admin/volunteers', 'refresh');
                }
            }
        }

        $data['name'] = $this->input->post('name');
        $data['username'] = preg_replace('/\s+/', '-', $this->input->post('username'));
        $data['email'] = $this->input->post('email');
        if ($this->db->get_where('volunteer', array('volunteer_id' => $param))->row()->password == "") {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }
        $data['mobile'] = $this->input->post('mobile');
        $data['batch'] = $this->input->post('batch');
        $data['profession_id'] = $this->input->post('profession_id');
        $data['status'] = $this->input->post('status');
        $data['step'] = 1;

        if ($this->db->get_where('volunteer', array('volunteer_id' => $param))->row()->password == "") {
            $message = $this->lang->line('add_volunteer_email_1') . ' ' . $data['email'] . '<br>' . $this->lang->line('add_volunteer_email_2') . ' ' . $this->input->post('password') . '<br><br>' . $this->lang->line('add_volunteer_email_3');

            $this->email_crud->send_email($this->db->get_where('about_us', array(
                'about_us_id' => 1,
            ))->row()->title . ' ' . $this->lang->line('volunteer_email'), 'volunteer', $data['email'], $message, $data['name']);
        }

        $this->db->where('volunteer_id', $param);
        $this->db->update('volunteer', $data);

        $this->session->set_flashdata('success', $this->lang->line('volunteer_updated'));

        redirect(base_url() . 'admin/volunteers', 'refresh');
    }

    // Deleting a volunteer
    public function delete_volunteer($param = '')
    {
        $this->db->where('volunteer_id', $param);
        $this->db->delete('volunteer');

        $this->session->set_flashdata('success', $this->lang->line('volunteer_deleted'));

        redirect(base_url() . 'admin/volunteers', 'refresh');
    }

    // Deleting a message
    public function delete_message($param = '')
    {
        $this->db->where('contact_us_message_id', $param);
        $this->db->delete('contact_us_message');

        // $this->session->set_flashdata('success', $this->lang->line('volunteer_deleted'));

        redirect(base_url() . 'admin/message', 'refresh');
    }

    // Adding a notice
    public function add_notice()
    {
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['timestamp'] = time();

        $this->db->insert('notice', $data);

        $this->session->set_flashdata('success', $this->lang->line('notice_added'));

        redirect(base_url() . 'admin/notices', 'refresh');
    }

    // Editing a notice
    public function edit_notice($param = '')
    {
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');

        $this->db->where('notice_id', $param);
        $this->db->update('notice', $data);

        $this->session->set_flashdata('success', $this->lang->line('notice_updated'));

        redirect(base_url() . 'admin/notices', 'refresh');
    }

    // Deleting a notice
    public function delete_notice($param = '')
    {
        $this->db->where('notice_id', $param);
        $this->db->delete('notice');

        $this->session->set_flashdata('success', $this->lang->line('notice_deleted'));

        redirect(base_url() . 'admin/notices', 'refresh');
    }

    // Adding a donation purpose
    public function add_donation_purpose()
    {
        $data['name'] = $this->input->post('name', true);
        $data['status'] = $this->input->post('status', true);
        $data['timestamp'] = time();

        $this->db->insert('donation_purpose', $data);

        $this->session->set_flashdata('success', $this->lang->line('donation_purpose_added'));

        redirect(base_url() . 'admin/manage_donation_purposes', 'refresh');
    }

    // Editing a donation purpose
    public function edit_donation_purpose($param = '')
    {
        $data['name'] = $this->input->post('name', true);
        $data['status'] = $this->input->post('status', true);
        $data['timestamp'] = time();

        $this->db->where('donation_purpose_id', $param);
        $this->db->update('donation_purpose', $data);

        $this->session->set_flashdata('success', $this->lang->line('donation_purpose_updated'));

        redirect(base_url() . 'admin/manage_donation_purposes', 'refresh');
    }

    // Deleting a donation purpose
    public function delete_donation_purpose($param = '')
    {
        $this->db->where('donation_purpose_id', $param);
        $this->db->delete('donation_purpose');

        $this->session->set_flashdata('success', $this->lang->line('donation_purpose_deleted'));

        redirect(base_url() . 'admin/manage_donation_purposes', 'refresh');
    }

    // Adding a donation
    public function add_donation()
    {
        $data['alumnus_id'] = $this->input->post('alumnus_id', true);
        $data['amount'] = $this->input->post('amount', true);
        $data['status'] = $this->input->post('status', true);
        $data['donation_purpose_id'] = $this->input->post('donation_purpose_id', true);
        $data['via'] = $this->input->post('via', true);
        $data['timestamp'] = time();

        $this->db->insert('donation', $data);

        $this->session->set_flashdata('success', $this->lang->line('donation_added'));

        redirect(base_url() . 'admin/donations', 'refresh');
    }

    // Editing a donation
    public function edit_donation($param = '')
    {
        $data['alumnus_id'] = $this->input->post('alumnus_id', true);
        $data['amount'] = $this->input->post('amount', true);
        $data['status'] = $this->input->post('status', true);
        $data['donation_purpose_id'] = $this->input->post('donation_purpose_id', true);
        $data['via'] = $this->input->post('via', true);
        $data['timestamp'] = time();

        $this->db->where('donation_id', $param);
        $this->db->update('donation', $data);

        $this->session->set_flashdata('success', $this->lang->line('donation_updated'));

        redirect(base_url() . 'admin/donations', 'refresh');
    }

    // Deleting a donation
    public function delete_donation($param = '')
    {
        $this->db->where('donation_id', $param);
        $this->db->delete('donation');

        $this->session->set_flashdata('success', $this->lang->line('donation_deleted'));

        redirect(base_url() . 'admin/donations', 'refresh');
    }

    // Updating contact us page settings part 1
    public function update_contact_us_part_1()
    {
        $data['title'] = $this->input->post('title');
        $data['address_line_1'] = $this->input->post('address_line_1');
        $data['address_line_2'] = $this->input->post('address_line_2');
        $data['telephone'] = $this->input->post('telephone');
        $data['email'] = $this->input->post('email');
        $data['description'] = $this->input->post('description');

        $this->db->where('contact_us_settings_id', '1');
        $this->db->update('contact_us_settings', $data);

        $this->session->set_flashdata('success', $this->lang->line('contact_us_part_1'));
        $this->session->set_flashdata('part_1', '1');

        redirect(base_url() . 'admin/contact_us', 'refresh');
    }

    // Updating contact us page settings part 2
    public function update_contact_us_part_2()
    {
        $data['twitter'] = $this->input->post('twitter');
        $data['facebook'] = $this->input->post('facebook');
        $data['linkedin'] = $this->input->post('linkedin');
        $data['documents'] = $this->input->post('documents');
        $data['youtube'] = $this->input->post('youtube');
        $data['google_map'] = $this->input->post('google_map');

        $this->db->where('contact_us_settings_id', '1');
        $this->db->update('contact_us_settings', $data);

        $this->session->set_flashdata('success', $this->lang->line('contact_us_part_2'));
        $this->session->set_flashdata('part_2', '1');

        redirect(base_url() . 'admin/contact_us', 'refresh');
    }

    // Updating website settings
    public function update_website_settings()
    {
        $data1['content'] = $this->input->post('frontend_title');
        $data2['content'] = $this->input->post('backend_title');
        $data3['content'] = $this->input->post('copyright');
        $data4['content'] = $this->input->post('call_us');
        $data5['content'] = $this->input->post('copyright_url');
        $data6['content'] = $this->input->post('language');
        $data7['content'] = $this->input->post('currency');
        $data8['content'] = $this->input->post('timezone');

        $this->db->where('setting_id', 1);
        $this->db->update('setting', $data1);

        $this->db->where('setting_id', 2);
        $this->db->update('setting', $data2);

        $this->db->where('setting_id', 3);
        $this->db->update('setting', $data3);

        $this->db->where('setting_id', 4);
        $this->db->update('setting', $data4);

        $this->db->where('setting_id', 9);
        $this->db->update('setting', $data5);

        $this->db->where('setting_id', 10);
        $this->db->update('setting', $data6);

        $this->db->where('setting_id', 11);
        $this->db->update('setting', $data7);

        $this->db->where('setting_id', 12);
        $this->db->update('setting', $data8);

        $this->session->set_flashdata('success', $this->lang->line('website_setting'));

        redirect(base_url() . 'admin/website_settings', 'refresh');
    }

    // Function related to website smtp
    public function update_website_smtp()
    {
        if ($this->input->post('smtp_user')) {
            $data1['content'] = $this->input->post('smtp_user');

            $this->db->where('name', 'smtp_user');
            $this->db->update('setting', $data1);
        }

        if ($this->input->post('smtp_pass')) {
            $data2['content'] = $this->input->post('smtp_pass');

            $this->db->where('name', 'smtp_pass');
            $this->db->update('setting', $data2);
        }

        $this->session->set_flashdata('success', $this->lang->line('website_smtp_updated_successfully'));

        redirect(base_url() . 'admin/website_settings', 'refresh');
    }

    // Function related to adding profession
    public function add_profession()
    {
        $data['name'] = $this->input->post('name');
        $data['timestamp'] = time();

        $this->db->insert('profession', $data);

        $this->session->set_flashdata('success', $this->lang->line('profession_added_successfully'));

        redirect(base_url() . 'admin/profession_settings', 'refresh');
    }

    // Function related to updating profession
    public function update_profession($profession_id = '')
    {
        $data['name'] = $this->input->post('name');
        $data['timestamp'] = time();

        $this->db->where('profession_id', $profession_id);
        $this->db->update('profession', $data);

        $this->session->set_flashdata('success', $this->lang->line('profession_updated_successfully'));

        redirect(base_url() . 'admin/profession_settings', 'refresh');
    }

    // Updating Favicon from Logo settings
    public function update_favicon()
    {
        $ext = pathinfo($_FILES['favicon']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $favicon = $this->db->get_where('setting', array(
                'setting_id' => 7,
            ))->row()->content;

            if (isset($favicon)) {
                unlink('uploads/logos/' . $favicon);
            }

            $data['content'] = $_FILES['favicon']['name'];

            move_uploaded_file($_FILES['favicon']['tmp_name'], 'uploads/logos/' . $data['content']);

            $this->db->where('setting_id', 7);
            $this->db->update('setting', $data);

            $this->session->set_flashdata('success', $this->lang->line('favicon_image'));
            $this->session->set_flashdata('favicon', '1');

            redirect(base_url() . 'admin/logo_settings', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('not_image'));
            $this->session->set_flashdata('favicon', '1');

            redirect(base_url() . 'admin/logo_settings', 'refresh');
        }
    }

    // Updating Header logo from Logo settings
    public function update_header_logo()
    {
        $ext = pathinfo($_FILES['header_logo']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $header_logo = $this->db->get_where('setting', array(
                'setting_id' => 5,
            ))->row()->content;

            if (isset($header_logo)) {
                unlink('uploads/logos/' . $header_logo);
            }

            $data['content'] = $_FILES['header_logo']['name'];

            move_uploaded_file($_FILES['header_logo']['tmp_name'], 'uploads/logos/' . $data['content']);

            $this->db->where('setting_id', 5);
            $this->db->update('setting', $data);

            $this->session->set_flashdata('success', $this->lang->line('message_header_logo'));
            $this->session->set_flashdata('header_logo', '1');

            redirect(base_url() . 'admin/logo_settings', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('not_image'));
            $this->session->set_flashdata('header_logo', '1');

            redirect(base_url() . 'admin/logo_settings', 'refresh');
        }
    }

    // Updating Footer logo from Logo settings
    public function update_footer_logo()
    {
        $ext = pathinfo($_FILES['footer_logo']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $footer_logo = $this->db->get_where('setting', array(
                'setting_id' => 6,
            ))->row()->content;

            if (isset($footer_logo)) {
                unlink('uploads/logos/' . $footer_logo);
            }

            $data['content'] = $_FILES['footer_logo']['name'];

            move_uploaded_file($_FILES['footer_logo']['tmp_name'], 'uploads/logos/' . $data['content']);

            $this->db->where('setting_id', 6);
            $this->db->update('setting', $data);

            $this->session->set_flashdata('success', $this->lang->line('message_footer_logo'));
            $this->session->set_flashdata('footer_logo', '1');

            redirect(base_url() . 'admin/logo_settings', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('not_image'));
            $this->session->set_flashdata('footer_logo', '1');

            redirect(base_url() . 'admin/logo_settings', 'refresh');
        }
    }

    // Updating Admin Panel Login Background from Login Background settings
    public function update_bg_settings()
    {
        $ext = pathinfo($_FILES['login_bg']['name'], PATHINFO_EXTENSION);

        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'JPEG' || $ext == 'JPG' || $ext == 'PNG') {
            $login_bg = $this->db->get_where('setting', array(
                'setting_id' => 8,
            ))->row()->content;

            if (isset($login_bg)) {
                unlink('uploads/bg_wallpaper/' . $login_bg);
            }

            $data['content'] = $_FILES['login_bg']['name'];

            move_uploaded_file($_FILES['login_bg']['tmp_name'], 'uploads/bg_wallpaper/' . $data['content']);

            $this->db->where('setting_id', 8);
            $this->db->update('setting', $data);

            $this->session->set_flashdata('success', $this->lang->line('login_bg'));

            redirect(base_url() . 'admin/bg_settings', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('not_image'));

            redirect(base_url() . 'admin/bg_settings', 'refresh');
        }
    }

    // Updating admin settings, email and password
    public function update_admin_settings()
    {
        $data['email'] = $this->input->post('email');
        $data['password'] = password_hash($this->input->post('new_password', true), PASSWORD_DEFAULT);

        $given_password = $this->input->post('old_password');
        $db_password = $this->db->get_where('admin', array('admin_id' => 1))->row()->password;

        // password_hash($this->input->post('password'), PASSWORD_DEFAULT)

        if (password_verify($given_password, $db_password)) {
            $this->db->where('admin_id', 1);
            $this->db->update('admin', $data);

            $this->session->set_flashdata('success', $this->lang->line('admin_setting'));

            redirect(base_url() . 'admin/admin_settings', 'refresh');
        } else {
            $this->session->set_flashdata('warning', $this->lang->line('admin_pwd_mismatch'));

            redirect(base_url() . 'admin/admin_settings', 'refresh');
        }
    }
}

          <ul class="nav nav-sidebar">
            <?php if($this->session->userdata('user_level') == '0'): ?>
            <li class="<?php echo $this->uri->segment(2) == 'settings' ? 'active' : ''; ?>"><a href="admin/settings">Instellingen</a></li>
            <li class="<?php echo $this->uri->segment(2) == 'movies' ? 'active' : ''; ?>"><a href="admin/movies">Films</a></li>
            <?php endif; ?>
            <li class="<?php echo $this->uri->segment(2) == 'votes' ? 'active' : ''; ?>"><a href="admin/votes">Stemuitslagen</a></li>
            <li class="<?php echo $this->uri->segment(2) == 'export' ? 'active' : ''; ?>"><a href="admin/export">Exporteren</a></li>
            <li class="<?php echo strpos($this->uri->segment(2), 'import') !== FALSE ? 'active' : ''; ?>"><a href="admin/import">Importeren</a></li>
          </ul>

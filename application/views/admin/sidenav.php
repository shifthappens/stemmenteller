          <ul class="nav nav-sidebar">
            <li class="<?php echo $this->uri->segment(2) == 'settings' ? 'active' : ''; ?>"><a href="admin/settings">Instellingen</a></li>
            <li class="<?php echo $this->uri->segment(2) == 'movies' ? 'active' : ''; ?>"><a href="admin/movies">Films</a></li>
            <li class="<?php echo $this->uri->segment(2) == 'votes' ? 'active' : ''; ?>"><a href="admin/votes">Stemmen</a></li>
            <li class="<?php echo $this->uri->segment(2) == 'export' ? 'active' : ''; ?>"><a href="admin/export">Exporteren</a></li>
          </ul>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?=$this->config->item('festival_name') ?> StemmenTeller Beheer</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Welkom, <strong><?=$this->session->userdata('user_name')?></strong>.</a></li>
            <li><a href="admin/logout" class="btn btn-link btn-danger">Log uit</a></li>
          </ul>
        </div>
      </div>
    </nav>
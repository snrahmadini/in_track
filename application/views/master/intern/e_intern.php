        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

          <a href="<?= base_url('master/intern'); ?>" class="btn btn-secondary btn-icon-split mb-4">
            <span class="icon text-white">
              <i class="fas fa-chevron-left"></i>
            </span>
            <span class="text">Back</span>
          </a>

          <?= form_open_multipart('master/e_intern/' . $intern['id']); ?>
          <div class="col-lg p-0">
            <div class="row">
              <div class="col-lg-3">
                <div class="card" style="width: 100%; height: 100%">
                  <img src="<?= base_url('images/pp/') . $intern['image']; ?>" class="card-img-top w-75 mx-auto pt-3">
                  <div class="card-body mt-3">
                    <label for="image">Change Intern Image</label>
                    <input type="file" name="image" id="image" class="mt-2">
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card">
                  <h5 class="card-header">Intern Master Data</h5>
                  <div class="card-body">
                    <h5 class="card-title">Edit Intern</h5>
                    <p class="card-text">Form to edit intern in system</p>
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="intern_id" class="col-form-label">Intern ID</label>
                          <input type="text" readonly class="form-control-plaintext" name="e_id" value="<?= $intern['id']; ?>">
                        </div>
                      </div>
                      <div class="col-lg-8">
                        <div class="form-group">
                          <label for="e_name" class="col-form-label">Intern Name</label>
                          <input type="text" class="form-control" name="e_name" id="e_name" value="<?= $intern['name']; ?>">
                          <?= form_error('e_name', '<small class="text-danger">', '</small>') ?>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="e_gender" class="col-form-label">Gender</label>
                          <div class="row col-lg">
                            <div class="form-check form-check-inline my-0">
                              <input class="form-check-input" type="radio" name="e_gender" id="m" value="M" <?php if ($intern['gender'] == 'M') {
                                                                                                              echo 'checked';
                                                                                                            }; ?>>
                              <label class="form-check-label" for="m">
                                Male
                              </label>
                              <?= form_error('e_gender', '<small class="text-danger">', '</small>') ?>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="e_gender" id="f" value="F" <?php if ($intern['gender'] == 'F') {
                                                                                                              echo 'checked';
                                                                                                            }; ?>>
                              <label class="form-check-label" for="f">
                                Female
                              </label>
                            </div>
                          </div>
                          <?= form_error('e_gender', '<small class="text-danger">', '</small>') ?>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="e_birth_date" class="col-form-label">Intern D.O.B</label>
                          <div class="col-lg p-0">
                            <input type="date" class="form-control" name="e_birth_date" id="e_birth_date" min="1900-01-01" max="2010-01-01" value="<?= $intern['birth_date']; ?>">
                            <?= form_error('e_birth_date', '<small class="text-danger">', '</small>') ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label for="e_hire_date" class="col-form-label">Hire Date</label>
                          <div class="col-lg p-0">
                            <input type="date" class="form-control" name="e_hire_date" id="e_hire_date" min="2004-04-16" max="<?= date('Y-m-d', time()); ?>" value="<?= $intern['hire_date']; ?>">
                            <?= form_error('e_hire_date', '<small class="text-danger">', '</small>') ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="d_id" class="col-form-label">Divisi</label>
                          <select class="form-control" name="d_id" id="d_id">
                            <?php foreach ($division as $dpt) : ?>
                              <option value="<?= $dpt['id'] ?>" <?php if ($dpt['id'] ==  $division_current['division_id']) {
                                                                  echo 'selected';
                                                                }; ?>><?= $dpt['id'] ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-icon-split mt-4 float-right">
                      <span class="icon text-white">
                        <i class="fas fa-check"></i>
                      </span>
                      <span class="text">Save Changes</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?= form_close(); ?>
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
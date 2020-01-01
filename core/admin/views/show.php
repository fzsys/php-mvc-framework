                <div class="vg-wrap vg-element vg-ninteen-of-twenty">
                    <div class="vg-element vg-fourth">
                        <a href="<?= $this->adminPath ?>add/<?= $this->table ?>"
                           class="vg-wrap vg-element vg-full vg-firm-background-color3 vg-box-shadow">
                            <div class="vg-element vg-half vg-center">
                                <img src="<?= PATH.ADMIN_TEMPLATE ?>/img/plus.png" alt="plus">
                            </div>
                            <div class="vg-element vg-half vg-center vg-firm-background-color1">
                                <span class="vg-text vg-firm-color3">Add</span>
                            </div>
                        </a>
                    </div>
                    <?php if($this->data): ?>
                        <?php foreach ($this->data as $data): ?>
                            <div class="vg-element vg-fourth">
                                <a href="<?= $this->adminPath ?>edit/<?= $this->table?>/<?= $data['id']?>"
                                   class="vg-wrap vg-element vg-full vg-firm-background-color4 vg-box-shadow show_element">
                                    <div class="vg-element vg-half vg-center">
                                        <img src="<?= $data['img'] && file_exists(PATH . UPLOAD_DIR . $data['img']) ? PATH . UPLOAD_DIR . $data['img'] : PATH.ADMIN_TEMPLATE . 'img/img-not-found.png' ?>"
                                             alt="<?= $data['img'] && file_exists(PATH . UPLOAD_DIR . $data['img']) ? $data['name'] : 'image not found'?>">
                                    </div>
                                    <div class="vg-element vg-half vg-center">
                                        <span class="vg-text vg-firm-color1"><?= $data['name'] ? $data['name'] : '<<без названия>>' ?></span>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
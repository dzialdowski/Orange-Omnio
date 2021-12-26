<div class="modal fade" id="kalkulatorMNPModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="MNPLabel" class="modal-title">Kalkulator MNP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"><span class="visually-hidden">Close</span></button>
            </div>
            <div class="modal-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <div class="alert alert-info" role="alert">
                            <span class="alert-icon"></span>
                            <p>W przypadku umowy na czas nieokreślony wybieramy w OMNI opcję "zgodnie z okresem wypowiedzenia"</p>
                        </div>
                        <button class="btn btn-primary btn-block" type="button" data-bs-toggle="collapse" data-bs-target="#additionalInfo" aria-expanded="false" aria-controls="stickers">Szczególne przypadki</button>
                        <div class="row">
                            <div class="col">
                                <div class="collapse multi-collapse" id="additionalInfo">
                                    <div class="alert alert-success" role="alert">
                                        <span class="alert-icon"></span>
                                        <p>MNPP (z karty na abo) ustalamy dowolny dzień w przedziale 20-50 dni od dnia wprowadzenia zamówienia</p>
                                    </div>

                                    <div class="alert alert-danger" role="alert">
                                        <span class="alert-icon"></span>
                                        <p>Flexa nie przeniesiemy! <br>Klient musi najpierw przenieść numer do innego operatora (najlepiej na kartę), tam ewentualnie zrobić cesję, a potem wrócić</p>
                                    </div>

                                    <div class="alert alert-warning" role="alert">
                                        <span class="alert-icon"></span>
                                        <p>Z nju mobile najpierw trzeba przejść na orange na kartę, potem ewentualnie zrobić cesję, potem jak dla migracji</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </br>
                        <div>
                            Wprowadź dzień początku cyklu rozliczeniowego <br>(na fakturze - "opłata za okres <b>OD</b>") i kliknij "Licz",<br>a dostaniesz dzień, który wpiszesz do OMNI jako dzień przeniesienia
                        </div>
                        <br>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="MNPday">Początek cyklu: </label>
                            </div>
                            <select class="custom-select" id="MNPday" aria-label="">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button" id="calculateMNPbutton">Licz</button>
                            </div>
                        </div>
                        <br>
                        <div class="collapse alert alert-info" id="showMNPinfo" role="alert">
                            <span class="alert-icon"><span class="sr-only">Info</span></span>
                            <p id="MNPdate">Przeniesiemy klienta dnia: </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij okno</button>
            </div>
        </div>
    </div>
</div>
<script src="mnpmodal.js"></script>
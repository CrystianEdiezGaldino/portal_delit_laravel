<style>
.dTop-cat_block {}

.dTop-cat {
    width: 100%;
}
.Ranking_Table {
    display: flex;
    width: 100%;
    max-width: 1200px;
    padding: 0 0 70px;
    flex-direction: column;
}
.Ranking_Table .table_border2 {
    margin: 0 0 30px;
    width: 100%;
    position: relative;
    border: 1px solid #787878;
    box-sizing: border-box;
    display: flex
;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    padding: 30px 0;
    text-align: center;
    font-size: 16px;
    color: #ddd;
    font-family: Manrope;}
	.relics_form {
    width: 100%;
    display: flex
;
    justify-content: center;
    margin-bottom: 30px;
    gap: 10px;
}
.relics_form a {
    cursor: pointer;
    opacity: .3;
    display: block;
    transition: .2s;
}
.relics_form img {
    width: 100%;
    max-width: 770px;
}
.filter-bar {
    width: 100%;
    position: relative;
    background-color: #333;
    border: 1.5px solid #222;
    box-sizing: border-box;
    height: 70px;
    display: flex
;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 25px 26px;
    text-align: left;
    font-size: 20px;
    color: #ddd;
    font-family: Manrope;
}
.Ranking_Table .table {
    width: 100%;
    position: relative;
    background-color: #080808;
    border: 1.5px solid #222;
    box-sizing: border-box;
    display: flex
;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    padding: 0 1px;
    text-align: center;
    font-size: 16px;
    color: #c2c2c2;
    font-family: Manrope;
}
.table {
    display: flex
;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    font-size: 14px;
    color: #787878;
}
.filter-bar {
    width: 100%;
    position: relative;
    background-color: #333;
    border: 1.5px solid #222;
    box-sizing: border-box;
    height: 70px;
    display: flex
;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 25px 26px;
    text-align: left;
    font-size: 20px;
    color: #ddd;
    font-family: Manrope;
}
.relics_form a.active {
    opacity: 1;
}
.relics_form a:hover {
    margin-top: -10px;
    opacity: 1;
}
.filter-character-diary {
    position: relative;
    line-height: 130%;
}
.Ranking_Table .header-row {
    align-self: stretch;
    background-color: #000;
    height: 70px;
    display: flex
;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.Ranking_Table .cell-parent {
    align-self: stretch;
    flex: 1;
    display: flex
;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
}
</style>
<div class="bg"></div>
<main class="main">
    <div class="container">
        <div class="top-content">
            <a href="" class="logo logo-big">
                <div class="img-container">
                    <img src="<?php echo base_url()?>assets/images/logo-big.png" alt="" />
                </div>
            </a>

        </div>
        <div class="download">
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="index.php">
                            <div class="breadcrumbs-icon"></div>

                            <span>Inicio</span>
                            <div class="icon-container">
                                <svg width="20px" height="16px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 13l-6-6-6 6" />
                                </svg>
                            </div>
                        </a>
                    </li>
                    <li><span>Download</span></li>
                </ul>
            </div>
            <div class="download-content">
                <div class="Ranking_Table">
                    <div class="table_border2">
                        <div class="if-you-have-container">TEXTO TEXTO </div>
                    </div>
                    <div class="relics_form">
                        <div><a class=""><img alt="" src="<?php echo base_url()?>assets//images/nation1_po.png"></a></div>
                        <div><a class="active"><img alt="" src="<?php echo base_url()?>assets//images/nation2_po.png"></a></div>
                        <div><a class=""><img alt="" src="<?php echo base_url()?>assets//images/nation3_po.png"></a></div>
                        <div><a class=""><img alt="" src="<?php echo base_url()?>assets//images/nation4_po.png"></a></div>
                        <div><a class=""><img alt="" src="<?php echo base_url()?>assets//images/nation5_po.png"></a></div>
                    </div>
                    <div class="filter-bar"><b class="filter-character-diary">Amarkand</b></div>
                    <div class="table table4">
                        <div class="header-row">
                            <div class="cell-parent">
                                <div class="cell"><b class="slot">Slot</b></div>
                                <div class="cell1"><b class="relics">Relíquias</b></div>
                                <div class="cell2"><b class="player">Jogador</b></div>
                                <div class="cell3"><b class="level">Nível</b></div>
                                <div class="cell4"><b class="player">Estabilização</b></div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="row4">
                                <div class="data"><img class="image-icon1" alt=""
                                        src="https://images.cbmgames.com/aika-br/static/relics/2443.png"></div>
                                <div class="data1">
                                    <div class="player">Espelho_Sagrado:_Azan_-Lv.2- </div>
                                </div>
                                <div class="data2"><img class="w01n01g329bmp-icon" alt=""
                                        src="https://images.cbmgames.com/aika-br/guildmark/w01n02g042.bmp?t=1737116380355"
                                        style="margin-right: 5px;">
                                    <div class="player">xRaizaNx </div>
                                </div>
                                <div class="data3">
                                    <div class="div">99</div>
                                </div>
                                <div class="data4">
                                    <div class="player"><span style="font-size: small;">17 de jan. de 2025</span></div>
                                </div>
                            </div>
                            <div class="row4">
                                <div class="data"><img class="image-icon1" alt=""
                                        src="https://images.cbmgames.com/aika-br/static/relics/5475.png"></div>
                                <div class="data1">
                                    <div class="player">Estaca_Sagrada:_Clavus_-Lv.2- </div>
                                </div>
                                <div class="data2"><img class="w01n01g329bmp-icon" alt=""
                                        src="https://images.cbmgames.com/aika-br/guildmark/w01n02g042.bmp?t=1737116380355"
                                        style="margin-right: 5px;">
                                    <div class="player">xRaizaNx </div>
                                </div>
                                <div class="data3">
                                    <div class="div">99</div>
                                </div>
                                <div class="data4">
                                    <div class="player"><span style="font-size: small;">17 de jan. de 2025</span></div>
                                </div>
                            </div>
                            <div class="row4">
                                <div class="data"><img class="image-icon1" alt=""
                                        src="https://images.cbmgames.com/aika-br/static/relics/215.png"></div>
                                <div class="data1">
                                    <div class="player">Diadema_Sagrada:_Luna_-Lv.1- </div>
                                </div>
                                <div class="data2"><img class="w01n01g329bmp-icon" alt=""
                                        src="https://images.cbmgames.com/aika-br/guildmark/w01n02g042.bmp?t=1737116380356"
                                        style="margin-right: 5px;">
                                    <div class="player">xRaizaNx </div>
                                </div>
                                <div class="data3">
                                    <div class="div">99</div>
                                </div>
                                <div class="data4">
                                    <div class="player"><span style="font-size: small;">17 de jan. de 2025</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-bar"><b class="filter-character-diary">Sigmund</b></div>
                    <div class="table table4">
                        <div class="header-row">
                            <div class="cell-parent">
                                <div class="cell"><b class="slot">Slot</b></div>
                                <div class="cell1"><b class="relics">Relíquias</b></div>
                                <div class="cell2"><b class="player">Jogador</b></div>
                                <div class="cell3"><b class="level">Nível</b></div>
                                <div class="cell4"><b class="player">Estabilização</b></div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="body">
                                <div class="row4">
                                    <div class="data"><img class="image-icon1" alt=""
                                            src="https://images.cbmgames.com/aika-br/static/relics/2440.png"></div>
                                    <div class="data1">
                                        <div class="player">Pedra_Sagrada:_Sarai_-Lv.2- </div>
                                    </div>
                                    <div class="data2"><img class="w01n01g329bmp-icon" alt=""
                                            src="https://images.cbmgames.com/aika-br/guildmark/w01n02g042.bmp?t=1737116380356"
                                            style="margin-right: 5px;">
                                        <div class="player">xRaizaNx </div>
                                    </div>
                                    <div class="data3">
                                        <div class="div">99</div>
                                    </div>
                                    <div class="data4">
                                        <div class="player"><span style="font-size: small;">17 de jan. de 2025</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row4">
                                    <div class="data"><img class="image-icon1" alt=""
                                            src="https://images.cbmgames.com/aika-br/static/relics/204.png"></div>
                                    <div class="data1">
                                        <div class="player">Túnica_Sagrada:_Kairos_-Lv.2- </div>
                                    </div>
                                    <div class="data2"><img class="w01n01g329bmp-icon" alt=""
                                            src="https://images.cbmgames.com/aika-br/guildmark/w01n02g042.bmp?t=1737116380356"
                                            style="margin-right: 5px;">
                                        <div class="player">xRaizaNx </div>
                                    </div>
                                    <div class="data3">
                                        <div class="div">99</div>
                                    </div>
                                    <div class="data4">
                                        <div class="player"><span style="font-size: small;">17 de jan. de 2025</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-bar"><b class="filter-character-diary">Cahill</b></div>
                    <div class="table table4">
                        <div class="header-row">
                            <div class="cell-parent">
                                <div class="cell"><b class="slot">Slot</b></div>
                                <div class="cell1"><b class="relics">Relíquias</b></div>
                                <div class="cell2"><b class="player">Jogador</b></div>
                                <div class="cell3"><b class="level">Nível</b></div>
                                <div class="cell4"><b class="player">Estabilização</b></div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="body">
                                <div class="row4">
                                    <div class="data"><img class="image-icon1" alt=""
                                            src="https://images.cbmgames.com/aika-br/static/relics/212.png"></div>
                                    <div class="data1">
                                        <div class="player">Gema_Sagrada:_Rosetta_-Lv.2- </div>
                                    </div>
                                    <div class="data2"><img class="w01n01g329bmp-icon" alt=""
                                            src="https://images.cbmgames.com/aika-br/guildmark/w01n02g042.bmp?t=1737116380356"
                                            style="margin-right: 5px;">
                                        <div class="player">xRaizaNx </div>
                                    </div>
                                    <div class="data3">
                                        <div class="div">99</div>
                                    </div>
                                    <div class="data4">
                                        <div class="player"><span style="font-size: small;">17 de jan. de 2025</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-bar"><b class="filter-character-diary">Mirza</b></div>
                    <div class="table table4">
                        <div class="header-row">
                            <div class="cell-parent">
                                <div class="cell"><b class="slot">Slot</b></div>
                                <div class="cell1"><b class="relics">Relíquias</b></div>
                                <div class="cell2"><b class="player">Jogador</b></div>
                                <div class="cell3"><b class="level">Nível</b></div>
                                <div class="cell4"><b class="player">Estabilização</b></div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="body">
                                <div class="row4">
                                    <div class="data"><img class="image-icon1" alt=""
                                            src="https://images.cbmgames.com/aika-br/static/relics/202.png"></div>
                                    <div class="data1">
                                        <div class="player">Lança_Sagrada:_Mauri_-Lv.2- </div>
                                    </div>
                                    <div class="data2"><img class="w01n01g329bmp-icon" alt=""
                                            src="https://images.cbmgames.com/aika-br/guildmark/w01n02g042.bmp?t=1737116380356"
                                            style="margin-right: 5px;">
                                        <div class="player">xRaizaNx </div>
                                    </div>
                                    <div class="data3">
                                        <div class="div">99</div>
                                    </div>
                                    <div class="data4">
                                        <div class="player"><span style="font-size: small;">17 de jan. de 2025</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row4">
                                    <div class="data"><img class="image-icon1" alt=""
                                            src="https://images.cbmgames.com/aika-br/static/relics/202.png"></div>
                                    <div class="data1">
                                        <div class="player">Lança_Sagrada:_Yahad_-Lv.2- </div>
                                    </div>
                                    <div class="data2"><img class="w01n01g329bmp-icon" alt=""
                                            src="https://images.cbmgames.com/aika-br/guildmark/w01n02g042.bmp?t=1737116380356"
                                            style="margin-right: 5px;">
                                        <div class="player">xRaizaNx </div>
                                    </div>
                                    <div class="data3">
                                        <div class="div">99</div>
                                    </div>
                                    <div class="data4">
                                        <div class="player"><span style="font-size: small;">17 de jan. de 2025</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row4">
                                    <div class="data"><img class="image-icon1" alt=""
                                            src="https://images.cbmgames.com/aika-br/static/relics/207.png"></div>
                                    <div class="data1">
                                        <div class="player">Estátua_Sagrada:_Parafora_-Lv.1- </div>
                                    </div>
                                    <div class="data2"><img class="w01n01g329bmp-icon" alt=""
                                            src="https://images.cbmgames.com/aika-br/guildmark/w01n02g042.bmp?t=1737116380356"
                                            style="margin-right: 5px;">
                                        <div class="player">xRaizaNx </div>
                                    </div>
                                    <div class="data3">
                                        <div class="div">99</div>
                                    </div>
                                    <div class="data4">
                                        <div class="player"><span style="font-size: small;">17 de jan. de 2025</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row4">
                                    <div class="data"><img class="image-icon1" alt=""
                                            src="https://images.cbmgames.com/aika-br/static/relics/201.png"></div>
                                    <div class="data1">
                                        <div class="player">Cálice_Sagrado:_Kyrios_-Lv.2- </div>
                                    </div>
                                    <div class="data2"><img class="w01n01g329bmp-icon" alt=""
                                            src="https://images.cbmgames.com/aika-br/guildmark/w01n02g042.bmp?t=1737116380356"
                                            style="margin-right: 5px;">
                                        <div class="player">Heatz </div>
                                    </div>
                                    <div class="data3">
                                        <div class="div">99</div>
                                    </div>
                                    <div class="data4">
                                        <div class="player"><span style="font-size: small;">17 de jan. de 2025</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    </div>
    <div class="main-shadow"></div>
</main>
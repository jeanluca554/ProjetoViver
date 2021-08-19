<table class="table table-hover table-responsive-sm tabelaParentesco" border="bordered" id="tabelaParentescoTeste">
    <thead class="thead-dark" align="center">
        <tr>
            <th>Responsável</th>
            <th width="150">CPF</th>
            <th width="170">Parentesco</th>
            
            <th width="50">Editar</th>
            <th width="50">Remover</th>              
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Mirela Caroline da Silva</td>
            <td>438.024.498-94</td>
            <td align="center">
                <select class="form-control" id="parentesco" onchange="salvarResponsavelDoAluno3(this.selectedIndex)">
                    <option value="0">Selecione...</option>
                    <option value="Mãe">Mãe</option>
                    <option value="Pai">Pai</option>
                    <option value="Responsavel">Responsável</option>
                </select>
            </td>
            <td align="center">
                <a class="btn btn-outline-info" href="#">
                    <img src="img/editar.png">
                </a>
            </td>
            <td align="center">
                <a class="btn btn-outline-danger" href="#">
                    <img src="img/menos-25.png">
                </a>
            </td>
        </tr>
        <tr>
            <td>Estelito Marcos Barbosa</td>
            <td>459.321.248-06</td>
            <td align="center">
                <select class="form-control" id="parentesco" onchange="salvarResponsavelDoAluno3(this.selectedIndex)">
                    <option value="0">Selecione...</option>
                    <option value="Mãe">Mãe</option>
                    <option value="Pai">Pai</option>
                    <option value="Responsavel">Responsável</option>
                </select>
            </td>
            <td align="center">
                <a class="btn btn-outline-info" href="#">
                    <img src="img/editar.png">
                </a>
            </td>
            <td align="center">
                <a class="btn btn-outline-danger" href="#">
                    <img src="img/menos-25.png">
                </a>
            </td>
        </tr>
        <tr>
            <td>Jean Luca dos Santos Barbosa</td>
            <td>459.321.248-06</td>
            <td align="center">
                <select class="form-control" id="parentesco4" onchange="salvarResponsavelDoAluno4()">
                    <option value="0">Selecione...</option>
                    <option value="Mãe">Mãe</option>
                    <option value="Pai">Pai</option>
                    <option value="Responsavel">Responsável</option>
                </select>
            </td>
            <td align="center">
                <a class="btn btn-outline-info" href="#">
                    <img src="img/editar.png">
                </a>
            </td>
            <td align="center">
                <a class="btn btn-outline-danger" href="#">
                    <img src="img/menos-25.png">
                </a>
            </td>
        </tr>
    </tbody>
</table>
<div class="form-row mt-5">
    <div class="form-row col-md-12">       
        <button type="submit" class="btn btn-success btn-lg" id="btnTesteSalvaAluno">Salvar</button>
        
    </div>
</div>

<script type="text/javascript" src="node_modules/bootstrap/js/jquery-3.3.1.min.js"/></script>
<script src="js/tabelaTeste.js"></script>

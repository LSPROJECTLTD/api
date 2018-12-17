<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Token $token
 */

$header = [
    'alg' => 'HS256',
    'typ' => 'JWT',
];
$header = json_encode($header);
$header = base64_encode($header);

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?=__('Actions')?></li>
        <li><?=$this->Html->link(__('List Token'), ['action' => 'index'])?></li>
    </ul>
</nav>
<div class="token form large-9 medium-8 columns content">
    <?=$this->Form->create($token)?>
    <fieldset>
        <legend><?=__('Add Token')?></legend>
        <?php
echo $this->Form->control('header', ['label' => 'Header', 'value' => $header, 'disabled' => 'disabled']);
echo $this->Form->control('iss', ['label' => 'Aplicação']);
echo $this->Form->control('name', ['label' => 'Nome do Responsavel']);
echo $this->Form->control('email', ['label' => 'E-mail do Responsavel']);
echo $this->Form->control('senha', ['label' => 'Senha']);
?>
    </fieldset>
    <?=$this->Form->button(__('Submit'))?>
    <?=$this->Form->end()?>
</div>

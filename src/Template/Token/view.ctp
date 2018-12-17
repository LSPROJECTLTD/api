<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Token $token
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?=__('Actions')?></li>
        <li><?=$this->Html->link(__('Edit Token'), ['action' => 'edit', $token->id])?> </li>
        <li><?=$this->Form->postLink(__('Delete Token'), ['action' => 'delete', $token->id], ['confirm' => __('Are you sure you want to delete # {0}?', $token->id)])?> </li>
        <li><?=$this->Html->link(__('List Token'), ['action' => 'index'])?> </li>
        <li><?=$this->Html->link(__('New Token'), ['action' => 'add'])?> </li>
    </ul>
</nav>
<div class="token view large-9 medium-8 columns content">
    <h3><?=h($token->id)?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?=__('Id')?></th>
            <td><?=$this->Number->format($token->id)?></td>
        </tr>
    </table>
    <div class="row">
    <div class="container-fluid">
    <div class="col-md-12">
        <h4> <?=__('Token')?></h4>
        <?php pr($token->token);?>
    </div>
    </div>
    </div>
</div>

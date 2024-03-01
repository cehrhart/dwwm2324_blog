{if (count($arrErrors) >0) }
    <div class="alert alert-danger">
        {foreach from=$arrErrors item=strError}
            <p>{$strError}</p>
        {/foreach}
    </div>
{/if}
{if (count($arrSuccess) >0) }
    <div class="alert alert-success">
        {foreach from=$arrSuccess item=strSuccess}
            <p>{$strSuccess}</p>
        {/foreach}
    </div>
{/if}
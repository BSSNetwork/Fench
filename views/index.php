        <div class="left">
            <h2>Foreach &amp; if example</h2>
            {comment}
            This is a comment
            {/comment}
            {if $array}
            {foreach $array as $key => $value}
            {$key} => {$value}<br />
            {/foreach}
            {else}
            {/*}This is also a comment{*/}
            <p>Array is empty!</p>
            {/if}
        </div>
        <div class="left">    
            <h2>While example</h2>
            {$i = 1}
            {while $i < $j}
            Show no. {$i}<br />
            {$i++}
            {/while}
        </div>
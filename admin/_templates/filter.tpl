            <span>{$translations.header.filter_jobs}</span>
            <ul>
                <li>
                    {if $filter != 'day'}
                        <a href="{$BASE_URL_ADMIN}advanced/{$current_category}/day/">{$translations.filter.day}</a>
                    {else}
                        <strong><a href="#">{$translations.filter.day}</a></strong>
                    {/if}
                </li>
                <li>
                    {if $filter != 'week'}
                        <a href="{$BASE_URL_ADMIN}advanced/{$current_category}/week/">{$translations.filter.week}</a>
                    {else}
                        <strong><a href="#">{$translations.filter.week}</a></strong>
                    {/if}
                </li>
                <li>
                    {if $filter != 'supmonth'}
                        <a href="{$BASE_URL_ADMIN}advanced/{$current_category}/supmonth/">{$translations.filter.supmonth}</a>
                    {else}
                        <strong><a href="#">{$translations.filter.supmonth}</a></strong>
                    {/if}
                </li>
                <li>
                    {if $filter != 'infmonth'}
                        <a href="{$BASE_URL_ADMIN}advanced/{$current_category}/infmonth/">{$translations.filter.infmonth}</a>
                    {else}
                        <strong><a href="#">{$translations.filter.infmonth}</a></strong>
                    {/if}
                </li>
                <li>
                    {if $filter != 'nofilter'}
                        <a href="{$BASE_URL_ADMIN}advanced/{$current_category}/nofilter/">{$translations.filter.nofilter}</a>
                    {else}
                        <strong><a href="#">{$translations.filter.nofilter}</a></strong>
                    {/if}
                </li>
            </ul>
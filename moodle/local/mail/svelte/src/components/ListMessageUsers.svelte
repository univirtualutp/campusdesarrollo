<!--
SPDX-FileCopyrightText: 2023-2024 Proyecto UNIMOODLE <direccion.area.estrategia.digital@uva.es>

SPDX-License-Identifier: GPL-3.0-or-later
-->
<svelte:options immutable={true} />

<script lang="ts">
    import { truncate } from '../actions/truncate';
    import type { MessageSummary } from '../lib/state';
    import type { Store } from '../lib/store';

    export let store: Store;
    export let message: MessageSummary;

    $: users =
        $store.params.tray == 'sent' || $store.params.tray == 'drafts'
            ? message.recipients.length > 0
                ? message.recipients.map((user) => user.fullname)
                : [$store.strings.norecipient]
            : [message.sender.fullname];
</script>

<div use:truncate={users.join('\n')}>
    {users.join(', ')}
</div>

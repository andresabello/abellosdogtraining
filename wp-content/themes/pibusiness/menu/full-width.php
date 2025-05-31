<div class="sub-item-wrapper">
    <a :href="encodeURI(item.url)">
        {{ item.title }}
    </a>
    <full-width-sub-menu v-if="Array.isArray(item.children) && item.children.length"
                         v-for="child in item.children" :key="item.ID"
                         :item="child"></full-width-sub-menu>
</div>

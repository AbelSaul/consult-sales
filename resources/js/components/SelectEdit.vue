<template>
  <v-select v-model="model" :items="items" item-value="price" item-text="price" label>
    <template slot="no-data">Precio no encontrado</template>
    <template slot="selection" slot-scope="{ index, item }">
      <span>{{ Number(item.price).toFixed(2) }}</span>
    </template>
    <template slot="item" slot-scope="{ index, item }">
      <v-list-tile-content>
        <v-text-field
          type="number"
          v-if="editing === item"
          v-model="editing.price"
          autofocus
          background-color="transparent"
          hide-details
          @keyup.enter="edit(index, item)"
        ></v-text-field>
        <v-chip
          v-else
          :color="`${colors[item.label[1]]} lighten-3`"
          dark
          label
          small
        >{{ Number(item.price).toFixed(2) }}</v-chip>
      </v-list-tile-content>
      <v-spacer></v-spacer>
      <v-list-tile-action @click.stop>
        <v-btn icon @click.stop.prevent="edit(index, item)">
          <v-icon>{{ editing !== item ? 'edit' : 'check' }}</v-icon>
        </v-btn>
      </v-list-tile-action>
    </template>
  </v-select>
</template>
<script>
export default {
  props: ["items", "value"],
  data: function() {
    return {
      colors: ["green", "purple", "indigo", "cyan", "teal", "orange"],
      editing: null,
      index: -1,
      menu: false,
      model: this.value
    };
  },
  watch: {
    model: function(val, prev) {
      this.$emit("input", val);
    },
    editing: {
      handler: function(val, oldVal) {
        console.log("in profunding");
        if (val) {
          this.$emit("input", val.price);
        }
        console.log(val, oldVal);
      },
      deep: true
    },
    value: function(val, prev) {
      this.model = val;
      this.$emit("input", val);
    }
  },
  methods: {
    edit(index, item) {
      if (!this.editing) {
        this.editing = item;
        this.index = index;
      } else {
        console.log(this.editing);
        this.editing = null;
        this.index = -1;
      }
    }
  }
};
</script>

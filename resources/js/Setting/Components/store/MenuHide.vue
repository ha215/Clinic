<template>
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="mt-4 mb-3 fw-normal">{{$t('customization.menu_hide')}}</h5>
    <div class="form-check fw-normal form-switch">
      <checkbox-input btn-name="sidebar_show" type="switch" label-title="Mini" label-class="overflow-hidden fw-normal p-0" id="sidebar-hide" :value="store.setting.sidebar_show.value == 'sidebar' ? 'sidebar-none' : 'sidebar'" @onChange="onUpdate"> </checkbox-input>
    </div>
  </div>
</template>
<script setup>
import {useSetting} from '@/store/index'
import CheckboxInput from '../store/elements/CheckboxInput.vue'
const store = useSetting()
const onUpdate = (value) => {
  store.sidebar_show(value[0])
}
</script>

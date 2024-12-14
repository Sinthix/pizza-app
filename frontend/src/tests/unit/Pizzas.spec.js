import { mount } from '@vue/test-utils';
import Pizza from '@/components/Pizzas/Pizzas.vue'; 

describe('Pizza.vue', () => {
  it('shows loader when loading is true', async () => {
    const wrapper = mount(Pizza);
    await wrapper.setData({ loading: true });

    const loader = wrapper.find('.loader-container');
    expect(loader.exists()).toBe(true);
  });

  it('does not show loader when loading is false', async () => {
    const wrapper = mount(Pizza);
    await wrapper.setData({ loading: false });

    const loader = wrapper.find('.loader-container');
    expect(loader.exists()).toBe(false);
  });

  it('opens pizza details modal when "View Details" is clicked', async () => {
    const wrapper = mount(Pizza, {
      data() {
        return {
          pizzas: [{ id: 1, name: 'Test Pizza', image: '', selling_price: 10 }],
          currentPizza: null,
          showPizzaDetailsFlag: false,
        };
      },
    });
  
    await wrapper.find('button.btn-outline-info').trigger('click');
    expect(wrapper.vm.showPizzaDetailsFlag).toBe(true);
  });
});

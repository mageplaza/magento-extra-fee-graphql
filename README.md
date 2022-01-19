# Magento 2 Extra Fee GraphQL

**Magento 2 Extra Fee GraphQL is a part of the Extra Fee extension by Mageplaza that supports stores with GraphQL features and PWA compatibility.** With this upgrade, it is possible for stores to have a more hassle-free experience when updating their system in the future.

[Mageplaza Extra Fee for Magento 2](https://www.mageplaza.com/magento-2-extra-fee/) supports stores in creating additional charges for any extra services. Those services range from gift wrapping, premium delivery, to customization requests and more.

Unlimited extra fees can be created and activated in specific conditions set in the backend. Based on conditions such as product attribute combination, product subselection, condition combination, payment methods, etc., the fees will be activated accordingly. You can also configure how the extra fee is calculated in 3 options: a fixed amount of each item, a fixed amount of the whole cart, or a percentage of the cart total. In the case of multiple rules, you can set priorities, with the smaller number the rule has, the more priority it gains.

Besides that, compulsory fees such as taxes or payment method charges can be applied automatically, while additional services such as gift wrapping or quick delivery can be set as manually applied. This feature helps stores comply with regulations and enhances customer experience when their interactions are put at the right place.  

Stores are able to set visibility for each extra fee so that only specific customer groups can see it in specific store views. What’s more, the fees can be viewed on various positions including Shopping Cart/ Payment Method, Email/PDF, or other billing documents.

Thanks to this module, stores can boost their sales, and customers can also fulfill their needs. While the default Magento 2 only allows specific fees such as Free Shipping, Table Rate, or Flat Rate, this module will definitely bring more flexibility as well as a better experience for both merchants and customers.


## 1. How to install

Run the following command in Magento 2 root folder:

```
composer require mageplaza/module-extra-fee-graphql
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

**Note:**
Mageplaza Extra Fee GraphQL requires installing [Mageplaza Extra Fee](https://www.mageplaza.com/magento-2-extra-fee/) in your Magento installation.

## 2. How to use

To perform GraphQL queries in Magento, please do the following requirements:

- Use Magento 2.3.x or higher. Set your site to [developer mode](https://www.mageplaza.com/devdocs/enable-disable-developer-mode-magento-2.html).
- Set GraphQL endpoint as `http://<magento2-server>/graphql` in url box, click **Set endpoint**.
  (e.g. `http://dev.site.com/graphql`)
- To view the queries that the **Mageplaza Extra Fee GraphQL** extension supports, you can look in `Docs > Query` in the right corner

## 3. Devdocs

## 4. Contribute to this module

Feel free to **Fork** and contribute to this module and create a pull request so we will merge your changes main branch.

## 5. Get Support

- Feel free to [contact us](https://www.mageplaza.com/contact.html) if you have any further questions.
- Like this project, Give us a **Star** ![star](https://i.imgur.com/S8e0ctO.png)

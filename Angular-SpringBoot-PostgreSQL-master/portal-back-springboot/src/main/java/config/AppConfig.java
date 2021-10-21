package com.api.config;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.*;
import org.springframework.core.env.Environment;
import org.springframework.orm.hibernate5.HibernateTransactionManager;
import org.springframework.orm.hibernate5.LocalSessionFactoryBean;
import org.springframework.transaction.annotation.EnableTransactionManagement;
import static org.hibernate.cfg.Environment.*;
import java.util.Properties;

@Configuration
@PropertySource("classpath:db_properties")
@EnableTransactionManagement
@ComponentScans(
        value={@ComponentScan("com.api.dao"), @ComponentScan("com.api.service")}
)
public class AppConfig {
    @Autowired
    private Environment env;

    @Bean
    public LocalSessionFactoryBean getSessionFactory(){
        LocalSessionFactoryBean factoryBean = new LocalSessionFactoryBean();
        Properties props = new Properties();
        //MySQL properties
        /*props.put(DRIVER,env.getProperty("mysql.driver"));
        props.put(URL,env.getProperty("mysql.url"));
        props.put(USER,env.getProperty("mysql.user"));
        props.put(PASS,env.getProperty("mysql.password"));*/
        //Hibernate properties
        props.put(SHOW_SQL, env.getProperty("hibernate.show_sql"));
        props.put(HBM2DDL_AUTO, env.getProperty("hibernate.hbm2ddl.auto"));
        //C3P0 properties
        props.put(C3P0_MIN_SIZE, env.getProperty("hibernate.c3p0.min_size"));
        props.put(C3P0_MAX_SIZE, env.getProperty("hibernate.c3p0.max_size"));
        props.put(C3P0_ACQUIRE_INCREMENT, env.getProperty("hibernate.c3p0.acquire_increment"));
        props.put(C3P0_TIMEOUT, env.getProperty("hibernate.c3p0.timeout"));
        props.put(C3P0_MAX_STATEMENTS, env.getProperty("hibernate.c3p0.max_statement"));
        //PostgreSQL properties
        props.put(URL, env.getProperty("spring.datasource.url"));
        props.put(USER, env.getProperty("spring.datasource.username"));
        props.put(PASS, env.getProperty("spring.datasource.password"));
        props.put(DRIVER, env.getProperty("spring.datasource.driver-class-name"));

        factoryBean.setHibernateProperties(props);
        factoryBean.setPackagesToScan("com.api.model");
        return factoryBean;
    }
    @Bean
    public HibernateTransactionManager getTransactionManager(){
        HibernateTransactionManager transactionManager = new HibernateTransactionManager();
        transactionManager.setSessionFactory(getSessionFactory().getObject());
        return transactionManager;
    }
}

<pre>

0. 镜像命名规则：系统盘:supergirl_server_sys_mirror_xxxx(递增) 
1. aliyun后台用镜像 supergirl_server_sys_mirror_xxxx(最新镜像)创建实例(数据盘也可用快照 k_supergirl_server_data_xxxx(最新快照)设置),
   实例规格同其他物理机, 新增磁盘一定要设置自动快照策略
2. 超女控制服(121.40.207.204)的 MySQL库 supergirlserver 的 t_machine 表，添加新物理机记录
3. 超女控制服(121.40.207.204)，对新物理机的内网地址开放 3306(mysql) 和 3690(svn) 端口
4. 自定义快照名称规则： 系统盘:k_supergirl_server_sys_xxxx(递增), 数据盘:k_supergirl_server_data_xxxx(递增)
5. 新物理机到备份服的信任关系
</pre>

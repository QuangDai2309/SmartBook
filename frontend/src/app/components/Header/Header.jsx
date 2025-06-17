'use client'
import React, { useState } from 'react';
import { MenuOutlined } from '@ant-design/icons';
import { Drawer, Button } from 'antd';
import { useRouter } from 'next/navigation';
import './Header.css';

const Header = () => {
  const router = useRouter();
  const [open, setOpen] = useState(false);

  const navItems = [
    { label: 'Ebooks', path: '/ebooks' },
    { label: 'Sách bán', path: '/buybooks' },
    { label: 'Waka Shop', path: '/shop' },
  ];

  const handleNav = (path) => {
    setOpen(false);
    router.push(path);
  };

  return (
    <header className="header">
      <div className="header-content">
        <div className="logo" onClick={() => router.push('/')}>
          WAKA <span className="logo-star">★</span>
        </div>

        <nav className="navigation">
          {navItems.map((item) => (
            <a key={item.path} onClick={() => handleNav(item.path)}>
              {item.label}
            </a>
          ))}
        </nav>

        <div className="hamburger">
          <Button
            type="text"
            icon={<MenuOutlined style={{ fontSize: '24px', color: 'white' }} />}
            onClick={() => setOpen(true)}
          />
        </div>
      </div>

      <Drawer
        title="Danh mục"
        placement="left"
        onClose={() => setOpen(false)}
        open={open}
      >
        {navItems.map((item) => (
          <p key={item.path} onClick={() => handleNav(item.path)} className="drawer-item">
            {item.label}
          </p>
        ))}
      </Drawer>
    </header>
  );
};

export default Header;

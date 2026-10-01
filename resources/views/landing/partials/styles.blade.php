    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        body { letter-spacing: -0.01em; }
        h1, h2, h3 { letter-spacing: -0.02em; }
        [data-lucide] { display: inline-block; vertical-align: middle; }

        .bg-yellow-ppid {
            background: linear-gradient(135deg, #fcd34d 0%, #facc15 60%, #eab308 100%);
        }

        /* â”€â”€ Exact AICLASSASEAN Style Card System â”€â”€ */
        .aiclass-section {
            background-color: #ffffff;
            padding: 55px 0 45px 0;
            text-align: center;
            position: relative;
        }
        .aiclass-filter-bar {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 26px;
            margin-bottom: 36px;
        }
        .aiclass-filter-btn {
            color: #666666;
            border: solid 1px #666666;
            background: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 8px 24px;
            border-radius: 10px;
            transition: all 0.2s ease;
            cursor: pointer;
            outline: none;
            text-decoration: none;
        }
        .aiclass-filter-btn.active, .aiclass-filter-btn:hover {
            background: linear-gradient(-90deg, #ca6673 0%, #9177c7 50%, #4796e3 100%) !important;
            color: #ffffff !important;
            border-color: transparent !important;
            box-shadow: 0 4px 14px rgba(71, 150, 227, 0.25);
        }
        /* ── Track Carousel ── */
        .aiclass-track {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding: 4px 0 16px 0;
        }
        .aiclass-track::-webkit-scrollbar {
            display: none;
        }

        /* ── Base Card: Sudut 90 Derajat (Kotak Siku), Memuat Tepat 4 Card di Layar Desktop ── */
        .aiclass-card {
            background: #ffffff;
            border: 1.5px solid #94a3b8;
            border-radius: 0px;
            padding: 14px 14px 0 14px;
            text-align: left;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            height: 405px;
            box-sizing: border-box;
            flex-shrink: 0;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
            /* Default 4 card: (100% - 3 * 20px gap) / 4 */
            width: calc((100% - 60px) / 4);
            min-width: calc((100% - 60px) / 4);
            max-width: calc((100% - 60px) / 4);
        }
        @media (max-width: 640px) {
            .aiclass-card {
                width: calc(100% - 20px);
                min-width: calc(100% - 20px);
                max-width: calc(100% - 20px);
            }
        }
        @media (min-width: 641px) and (max-width: 1024px) {
            .aiclass-card {
                width: calc((100% - 20px) / 2);
                min-width: calc((100% - 20px) / 2);
                max-width: calc((100% - 20px) / 2);
            }
        }
        @media (min-width: 1025px) {
            .aiclass-card {
                width: calc((100% - 60px) / 4);
                min-width: calc((100% - 60px) / 4);
                max-width: calc((100% - 60px) / 4);
            }
        }

        .aiclass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            border-color: #475569;
        }
        .aiclass-card .card-img-wrap {
            border-radius: 0px;
            overflow: hidden;
            aspect-ratio: 16 / 9;
            width: 100%;
            background-color: #f1f5f9;
        }
        .aiclass-card .card-img-wrap img {
            border-radius: 0px;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
            display: block;
        }
        .aiclass-card:hover .card-img-wrap img {
            transform: scale(1.05);
        }
        .aiclass-card .tags {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .aiclass-card .tags .competency {
            display: inline-block;
            border-radius: 4px;
            background-color: #355bdc;
            font-weight: 700;
            padding: 3px 8px;
            color: #ffffff;
            font-size: 0.65rem;
            line-height: 1.2;
        }
        .aiclass-card .tags .time {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border-radius: 4px;
            background-color: #e84435;
            font-weight: 700;
            padding: 3px 8px;
            color: #ffffff;
            font-size: 0.65rem;
            line-height: 1.2;
        }
        .aiclass-card h5 {
            margin-top: 8px;
            margin-bottom: 0;
            font-weight: 700;
            font-size: 1.05rem;
            color: #0f172a;
            height: 52px;
            display: flex;
            align-items: center;
            line-height: 1.35;
            overflow: hidden;
        }
        .aiclass-card .meta-row {
            margin-top: 8px;
            border-top: solid 1px #000000;
            border-bottom: solid 1px #000000;
            font-size: 0.72rem;
            color: #333333;
            padding: 6px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        .aiclass-card .btn-detail {
            background-color: #ff9800;
            font-weight: 700;
            color: #ffffff !important;
            border-radius: 8px 8px 0 0;
            font-size: 0.78rem;
            padding: 8px 24px;
            display: inline-block;
            margin-bottom: 0;
            transition: background-color 0.2s ease;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .aiclass-card .btn-detail:hover {
            background-color: #e68d00;
            color: #ffffff !important;
        }

        /* ── Controls: Counter (Kiri), Progress Bar / Scrollbar (Tengah Luas), Tombol Navigasi (Kanan) ── */
        .aiclass-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-top: 26px;
            width: 100%;
        }
        .aiclass-counter {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e293b;
            min-width: 45px;
            flex-shrink: 0;
            letter-spacing: -0.01em;
        }
        .aiclass-progress-track {
            flex: 1;
            height: 4px;
            background: #e2e8f0;
            border-radius: 99px;
            margin: 0 20px;
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }
        .aiclass-progress-thumb {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: #e84435;
            border-radius: 99px;
            transition: left 0.15s ease-out, width 0.2s ease;
        }
        .aiclass-nav-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }
        .aiclass-nav-arrow {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: solid 1.5px #94a3b8;
            background: #ffffff;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
            outline: none;
        }
        .aiclass-nav-arrow:hover {
            border-color: #0f172a;
            color: #0f172a;
            background-color: #f8fafc;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }
        .aiclass-nav-arrow:active {
            transform: scale(0.94);
        }

        /* â”€â”€ Exact AICLASSASEAN Style Header Login Button â”€â”€ */
        .btn-join {
            background-color: #355bdc;
            color: #ffffff !important;
            font-weight: 700;
            padding: 5px 6px 5px 12px;
            display: inline-flex;
            align-items: center;
            border-radius: 6px;
            white-space: nowrap;
            text-decoration: none;
            font-size: 0.85rem;
            line-height: 1.2;
            transition: all 0.25s ease;
            box-shadow: 0 2px 6px rgba(53, 91, 220, 0.2);
            cursor: pointer;
        }
        .btn-join span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            border-radius: 4px;
            color: #355bdc;
            width: 20px;
            height: 20px;
            margin-left: 8px;
            font-size: 0.65rem;
            transition: transform 0.2s ease;
        }
        .btn-join:hover {
            background: linear-gradient(-90deg, #ca6673 0%, #9177c7 50%, #4796e3 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(71, 150, 227, 0.35);
        }
        .btn-join:hover span {
            transform: translateX(2px);
            color: #ca6673;
        }

        [x-cloak] { display: none !important; }
    </style>

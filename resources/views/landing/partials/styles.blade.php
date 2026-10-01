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
        .aiclass-card {
            background: #ffffff;
            border: solid 1px #666666;
            border-radius: 20px;
            padding: 15px 15px 0 15px;
            text-align: left;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            width: 320px;
            min-width: 320px;
            max-width: 320px;
            height: 485px;
            box-sizing: border-box;
            flex-shrink: 0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .aiclass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.08);
        }
        .aiclass-card .card-img-wrap {
            border-radius: 15px;
            overflow: hidden;
            aspect-ratio: 16 / 9;
            width: 100%;
            background-color: #f1f5f9;
        }
        .aiclass-card .card-img-wrap img {
            border-radius: 15px;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
            display: block;
        }
        .aiclass-card:hover .card-img-wrap img {
            transform: scale(1.15);
        }
        .aiclass-card .tags {
            margin-top: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .aiclass-card .tags .competency {
            display: inline-block;
            border-radius: 5px;
            background-color: #355bdc;
            font-weight: 700;
            padding: 4px 8px;
            color: #ffffff;
            font-size: 0.65rem;
            line-height: 1.1;
        }
        .aiclass-card .tags .time {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border-radius: 5px;
            background-color: #e84435;
            font-weight: 700;
            padding: 4px 8px;
            color: #ffffff;
            font-size: 0.65rem;
            line-height: 1.1;
        }
        .aiclass-card h5 {
            margin-top: 10px;
            margin-bottom: 0;
            font-weight: 700;
            font-size: 1.05rem;
            color: #000000;
            height: 56px;
            display: flex;
            align-items: center;
            line-height: 1.3;
            overflow: hidden;
        }
        .aiclass-card .meta-row {
            margin-top: 10px;
            border-top: solid 1px #000000;
            border-bottom: solid 1px #000000;
            font-size: 0.8rem;
            color: #333333;
            padding: 6px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0;
        }
        .aiclass-card .btn-detail {
            background-color: #ff9d00;
            font-weight: 700;
            color: #ffffff;
            border-radius: 15px 15px 0 0;
            font-size: 0.8rem;
            padding: 6px 20px;
            display: inline-block;
            margin-top: 10px;
            transition: background-color 0.2s ease;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .aiclass-card .btn-detail:hover {
            background-color: #e68d00;
            color: #ffffff;
        }
        .aiclass-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-top: 24px;
        }
        .aiclass-nav-arrow {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: solid 1px #666666;
            background: #ffffff;
            color: #666666;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .aiclass-nav-arrow:hover {
            border-color: #000000;
            color: #000000;
            background-color: #f8fafc;
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

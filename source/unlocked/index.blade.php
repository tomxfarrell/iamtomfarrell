<!doctype html>
<html class="staticrypt-html">
<head>
    <meta charset="utf-8">
    <title>Protected Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- do not cache this page -->
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT"/>
    <meta http-equiv="pragma" content="no-cache"/>

    <style>
        .staticrypt-hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #eee;
        }

        .staticrypt-page {
            width: 360px;
            padding: 8% 0 0;
            margin: auto;
            box-sizing: border-box;
        }

        .staticrypt-form {
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            max-width: 360px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }

        .staticrypt-form input[type="password"] {
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .staticrypt-form .staticrypt-decrypt-button {
            text-transform: uppercase;
            outline: 0;
            background: #4CAF50;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #FFFFFF;
            font-size: 14px;
            cursor: pointer;
        }

        .staticrypt-form .staticrypt-decrypt-button:hover, .staticrypt-form .staticrypt-decrypt-button:active, .staticrypt-form .staticrypt-decrypt-button:focus {
            background: #43A047;
        }

        .staticrypt-html {
            height: 100%;
        }

        .staticrypt-body {
            margin-bottom: 1em;
            background: #302E6F; /* fallback for old browsers */
            font-family: "Arial", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .staticrypt-instructions {
            margin-top: -1em;
            margin-bottom: 1em;
        }

        .staticrypt-title {
            font-size: 1.5em;
        }

        .staticrypt-footer {
            position: fixed;
            height: 20px;
            font-size: 16px;
            padding: 2px;
            bottom: 0;
            left: 0;
            right: 0;
            margin-bottom: 0;
        }

        .staticrypt-footer p {
            margin: 2px;
            text-align: center;
            float: right;
        }

        .staticrypt-footer a {
            text-decoration: none;
        }

        label.staticrypt-remember {
            display: flex;
            align-items: center;
            margin-bottom: 1em;
        }

        .staticrypt-remember input[type=checkbox] {
            transform: scale(1.5);
            margin-right: 1em;
        }

        .hidden {
            display: none !important;
        }
    </style>
</head>

<body class="staticrypt-body">
<div class="staticrypt-page">
    <div class="staticrypt-form">
        <div class="staticrypt-instructions">
            <p class="staticrypt-title">Protected Page</p>
            <p></p>
        </div>

        <hr class="staticrypt-hr">

        <form id="staticrypt-form" action="#" method="post">
            <input id="staticrypt-password"
                   type="password"
                   name="password"
                   placeholder="Passphrase"
                   autofocus/>

            <label id="staticrypt-remember-label" class="staticrypt-remember hidden">
                <input id="staticrypt-remember"
                       type="checkbox"
                       name="remember"/>
                Remember me
            </label>

            <input type="submit" class="staticrypt-decrypt-button" value="Unlock"/>
        </form>
    </div>

</div>
<footer class="staticrypt-footer">
    <p class="pull-right">Created with <a href="https://robinmoisson.github.io/staticrypt">StatiCrypt</a></p>
</footer>


<script>/**
 * Crypto JS 3.1.9-1
 * Copied as is from https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js
 */

;(function (root, factory) {
    if (typeof exports === "object") {
        // CommonJS
        module.exports = exports = factory();
    }
    else if (typeof define === "function" && define.amd) {
        // AMD
        define([], factory);
    }
    else {
        // Global (browser)
        root.CryptoJS = factory();
    }
}(this, function () {

    /**
     * CryptoJS core components.
     */
    var CryptoJS = CryptoJS || (function (Math, undefined) {
        /*
	     * Local polyfil of Object.create
	     */
        var create = Object.create || (function () {
            function F() {};

            return function (obj) {
                var subtype;

                F.prototype = obj;

                subtype = new F();

                F.prototype = null;

                return subtype;
            };
        }())

        /**
         * CryptoJS namespace.
         */
        var C = {};

        /**
         * Library namespace.
         */
        var C_lib = C.lib = {};

        /**
         * Base object for prototypal inheritance.
         */
        var Base = C_lib.Base = (function () {


            return {
                /**
                 * Creates a new object that inherits from this object.
                 *
                 * @param {Object} overrides Properties to copy into the new object.
                 *
                 * @return {Object} The new object.
                 *
                 * @static
                 *
                 * @example
                 *
                 *     var MyType = CryptoJS.lib.Base.extend({
	             *         field: 'value',
	             *
	             *         method: function () {
	             *         }
	             *     });
                 */
                extend: function (overrides) {
                    // Spawn
                    var subtype = create(this);

                    // Augment
                    if (overrides) {
                        subtype.mixIn(overrides);
                    }

                    // Create default initializer
                    if (!subtype.hasOwnProperty('init') || this.init === subtype.init) {
                        subtype.init = function () {
                            subtype.$super.init.apply(this, arguments);
                        };
                    }

                    // Initializer's prototype is the subtype object
                    subtype.init.prototype = subtype;

                    // Reference supertype
                    subtype.$super = this;

                    return subtype;
                },

                /**
                 * Extends this object and runs the init method.
                 * Arguments to create() will be passed to init().
                 *
                 * @return {Object} The new object.
                 *
                 * @static
                 *
                 * @example
                 *
                 *     var instance = MyType.create();
                 */
                create: function () {
                    var instance = this.extend();
                    instance.init.apply(instance, arguments);

                    return instance;
                },

                /**
                 * Initializes a newly created object.
                 * Override this method to add some logic when your objects are created.
                 *
                 * @example
                 *
                 *     var MyType = CryptoJS.lib.Base.extend({
	             *         init: function () {
	             *             // ...
	             *         }
	             *     });
                 */
                init: function () {
                },

                /**
                 * Copies properties into this object.
                 *
                 * @param {Object} properties The properties to mix in.
                 *
                 * @example
                 *
                 *     MyType.mixIn({
	             *         field: 'value'
	             *     });
                 */
                mixIn: function (properties) {
                    for (var propertyName in properties) {
                        if (properties.hasOwnProperty(propertyName)) {
                            this[propertyName] = properties[propertyName];
                        }
                    }

                    // IE won't copy toString using the loop above
                    if (properties.hasOwnProperty('toString')) {
                        this.toString = properties.toString;
                    }
                },

                /**
                 * Creates a copy of this object.
                 *
                 * @return {Object} The clone.
                 *
                 * @example
                 *
                 *     var clone = instance.clone();
                 */
                clone: function () {
                    return this.init.prototype.extend(this);
                }
            };
        }());

        /**
         * An array of 32-bit words.
         *
         * @property {Array} words The array of 32-bit words.
         * @property {number} sigBytes The number of significant bytes in this word array.
         */
        var WordArray = C_lib.WordArray = Base.extend({
            /**
             * Initializes a newly created word array.
             *
             * @param {Array} words (Optional) An array of 32-bit words.
             * @param {number} sigBytes (Optional) The number of significant bytes in the words.
             *
             * @example
             *
             *     var wordArray = CryptoJS.lib.WordArray.create();
             *     var wordArray = CryptoJS.lib.WordArray.create([0x00010203, 0x04050607]);
             *     var wordArray = CryptoJS.lib.WordArray.create([0x00010203, 0x04050607], 6);
             */
            init: function (words, sigBytes) {
                words = this.words = words || [];

                if (sigBytes != undefined) {
                    this.sigBytes = sigBytes;
                } else {
                    this.sigBytes = words.length * 4;
                }
            },

            /**
             * Converts this word array to a string.
             *
             * @param {Encoder} encoder (Optional) The encoding strategy to use. Default: CryptoJS.enc.Hex
             *
             * @return {string} The stringified word array.
             *
             * @example
             *
             *     var string = wordArray + '';
             *     var string = wordArray.toString();
             *     var string = wordArray.toString(CryptoJS.enc.Utf8);
             */
            toString: function (encoder) {
                return (encoder || Hex).stringify(this);
            },

            /**
             * Concatenates a word array to this word array.
             *
             * @param {WordArray} wordArray The word array to append.
             *
             * @return {WordArray} This word array.
             *
             * @example
             *
             *     wordArray1.concat(wordArray2);
             */
            concat: function (wordArray) {
                // Shortcuts
                var thisWords = this.words;
                var thatWords = wordArray.words;
                var thisSigBytes = this.sigBytes;
                var thatSigBytes = wordArray.sigBytes;

                // Clamp excess bits
                this.clamp();

                // Concat
                if (thisSigBytes % 4) {
                    // Copy one byte at a time
                    for (var i = 0; i < thatSigBytes; i++) {
                        var thatByte = (thatWords[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                        thisWords[(thisSigBytes + i) >>> 2] |= thatByte << (24 - ((thisSigBytes + i) % 4) * 8);
                    }
                } else {
                    // Copy one word at a time
                    for (var i = 0; i < thatSigBytes; i += 4) {
                        thisWords[(thisSigBytes + i) >>> 2] = thatWords[i >>> 2];
                    }
                }
                this.sigBytes += thatSigBytes;

                // Chainable
                return this;
            },

            /**
             * Removes insignificant bits.
             *
             * @example
             *
             *     wordArray.clamp();
             */
            clamp: function () {
                // Shortcuts
                var words = this.words;
                var sigBytes = this.sigBytes;

                // Clamp
                words[sigBytes >>> 2] &= 0xffffffff << (32 - (sigBytes % 4) * 8);
                words.length = Math.ceil(sigBytes / 4);
            },

            /**
             * Creates a copy of this word array.
             *
             * @return {WordArray} The clone.
             *
             * @example
             *
             *     var clone = wordArray.clone();
             */
            clone: function () {
                var clone = Base.clone.call(this);
                clone.words = this.words.slice(0);

                return clone;
            },

            /**
             * Creates a word array filled with random bytes.
             *
             * @param {number} nBytes The number of random bytes to generate.
             *
             * @return {WordArray} The random word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.lib.WordArray.random(16);
             */
            random: function (nBytes) {
                var words = [];

                var r = (function (m_w) {
                    var m_w = m_w;
                    var m_z = 0x3ade68b1;
                    var mask = 0xffffffff;

                    return function () {
                        m_z = (0x9069 * (m_z & 0xFFFF) + (m_z >> 0x10)) & mask;
                        m_w = (0x4650 * (m_w & 0xFFFF) + (m_w >> 0x10)) & mask;
                        var result = ((m_z << 0x10) + m_w) & mask;
                        result /= 0x100000000;
                        result += 0.5;
                        return result * (Math.random() > .5 ? 1 : -1);
                    }
                });

                for (var i = 0, rcache; i < nBytes; i += 4) {
                    var _r = r((rcache || Math.random()) * 0x100000000);

                    rcache = _r() * 0x3ade67b7;
                    words.push((_r() * 0x100000000) | 0);
                }

                return new WordArray.init(words, nBytes);
            }
        });

        /**
         * Encoder namespace.
         */
        var C_enc = C.enc = {};

        /**
         * Hex encoding strategy.
         */
        var Hex = C_enc.Hex = {
            /**
             * Converts a word array to a hex string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The hex string.
             *
             * @static
             *
             * @example
             *
             *     var hexString = CryptoJS.enc.Hex.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var hexChars = [];
                for (var i = 0; i < sigBytes; i++) {
                    var bite = (words[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                    hexChars.push((bite >>> 4).toString(16));
                    hexChars.push((bite & 0x0f).toString(16));
                }

                return hexChars.join('');
            },

            /**
             * Converts a hex string to a word array.
             *
             * @param {string} hexStr The hex string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Hex.parse(hexString);
             */
            parse: function (hexStr) {
                // Shortcut
                var hexStrLength = hexStr.length;

                // Convert
                var words = [];
                for (var i = 0; i < hexStrLength; i += 2) {
                    words[i >>> 3] |= parseInt(hexStr.substr(i, 2), 16) << (24 - (i % 8) * 4);
                }

                return new WordArray.init(words, hexStrLength / 2);
            }
        };

        /**
         * Latin1 encoding strategy.
         */
        var Latin1 = C_enc.Latin1 = {
            /**
             * Converts a word array to a Latin1 string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The Latin1 string.
             *
             * @static
             *
             * @example
             *
             *     var latin1String = CryptoJS.enc.Latin1.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var latin1Chars = [];
                for (var i = 0; i < sigBytes; i++) {
                    var bite = (words[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff;
                    latin1Chars.push(String.fromCharCode(bite));
                }

                return latin1Chars.join('');
            },

            /**
             * Converts a Latin1 string to a word array.
             *
             * @param {string} latin1Str The Latin1 string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Latin1.parse(latin1String);
             */
            parse: function (latin1Str) {
                // Shortcut
                var latin1StrLength = latin1Str.length;

                // Convert
                var words = [];
                for (var i = 0; i < latin1StrLength; i++) {
                    words[i >>> 2] |= (latin1Str.charCodeAt(i) & 0xff) << (24 - (i % 4) * 8);
                }

                return new WordArray.init(words, latin1StrLength);
            }
        };

        /**
         * UTF-8 encoding strategy.
         */
        var Utf8 = C_enc.Utf8 = {
            /**
             * Converts a word array to a UTF-8 string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The UTF-8 string.
             *
             * @static
             *
             * @example
             *
             *     var utf8String = CryptoJS.enc.Utf8.stringify(wordArray);
             */
            stringify: function (wordArray) {
                try {
                    return decodeURIComponent(escape(Latin1.stringify(wordArray)));
                } catch (e) {
                    throw new Error('Malformed UTF-8 data');
                }
            },

            /**
             * Converts a UTF-8 string to a word array.
             *
             * @param {string} utf8Str The UTF-8 string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Utf8.parse(utf8String);
             */
            parse: function (utf8Str) {
                return Latin1.parse(unescape(encodeURIComponent(utf8Str)));
            }
        };

        /**
         * Abstract buffered block algorithm template.
         *
         * The property blockSize must be implemented in a concrete subtype.
         *
         * @property {number} _minBufferSize The number of blocks that should be kept unprocessed in the buffer. Default: 0
         */
        var BufferedBlockAlgorithm = C_lib.BufferedBlockAlgorithm = Base.extend({
            /**
             * Resets this block algorithm's data buffer to its initial state.
             *
             * @example
             *
             *     bufferedBlockAlgorithm.reset();
             */
            reset: function () {
                // Initial values
                this._data = new WordArray.init();
                this._nDataBytes = 0;
            },

            /**
             * Adds new data to this block algorithm's buffer.
             *
             * @param {WordArray|string} data The data to append. Strings are converted to a WordArray using UTF-8.
             *
             * @example
             *
             *     bufferedBlockAlgorithm._append('data');
             *     bufferedBlockAlgorithm._append(wordArray);
             */
            _append: function (data) {
                // Convert string to WordArray, else assume WordArray already
                if (typeof data == 'string') {
                    data = Utf8.parse(data);
                }

                // Append
                this._data.concat(data);
                this._nDataBytes += data.sigBytes;
            },

            /**
             * Processes available data blocks.
             *
             * This method invokes _doProcessBlock(offset), which must be implemented by a concrete subtype.
             *
             * @param {boolean} doFlush Whether all blocks and partial blocks should be processed.
             *
             * @return {WordArray} The processed data.
             *
             * @example
             *
             *     var processedData = bufferedBlockAlgorithm._process();
             *     var processedData = bufferedBlockAlgorithm._process(!!'flush');
             */
            _process: function (doFlush) {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;
                var dataSigBytes = data.sigBytes;
                var blockSize = this.blockSize;
                var blockSizeBytes = blockSize * 4;

                // Count blocks ready
                var nBlocksReady = dataSigBytes / blockSizeBytes;
                if (doFlush) {
                    // Round up to include partial blocks
                    nBlocksReady = Math.ceil(nBlocksReady);
                } else {
                    // Round down to include only full blocks,
                    // less the number of blocks that must remain in the buffer
                    nBlocksReady = Math.max((nBlocksReady | 0) - this._minBufferSize, 0);
                }

                // Count words ready
                var nWordsReady = nBlocksReady * blockSize;

                // Count bytes ready
                var nBytesReady = Math.min(nWordsReady * 4, dataSigBytes);

                // Process blocks
                if (nWordsReady) {
                    for (var offset = 0; offset < nWordsReady; offset += blockSize) {
                        // Perform concrete-algorithm logic
                        this._doProcessBlock(dataWords, offset);
                    }

                    // Remove processed words
                    var processedWords = dataWords.splice(0, nWordsReady);
                    data.sigBytes -= nBytesReady;
                }

                // Return processed words
                return new WordArray.init(processedWords, nBytesReady);
            },

            /**
             * Creates a copy of this object.
             *
             * @return {Object} The clone.
             *
             * @example
             *
             *     var clone = bufferedBlockAlgorithm.clone();
             */
            clone: function () {
                var clone = Base.clone.call(this);
                clone._data = this._data.clone();

                return clone;
            },

            _minBufferSize: 0
        });

        /**
         * Abstract hasher template.
         *
         * @property {number} blockSize The number of 32-bit words this hasher operates on. Default: 16 (512 bits)
         */
        var Hasher = C_lib.Hasher = BufferedBlockAlgorithm.extend({
            /**
             * Configuration options.
             */
            cfg: Base.extend(),

            /**
             * Initializes a newly created hasher.
             *
             * @param {Object} cfg (Optional) The configuration options to use for this hash computation.
             *
             * @example
             *
             *     var hasher = CryptoJS.algo.SHA256.create();
             */
            init: function (cfg) {
                // Apply config defaults
                this.cfg = this.cfg.extend(cfg);

                // Set initial values
                this.reset();
            },

            /**
             * Resets this hasher to its initial state.
             *
             * @example
             *
             *     hasher.reset();
             */
            reset: function () {
                // Reset data buffer
                BufferedBlockAlgorithm.reset.call(this);

                // Perform concrete-hasher logic
                this._doReset();
            },

            /**
             * Updates this hasher with a message.
             *
             * @param {WordArray|string} messageUpdate The message to append.
             *
             * @return {Hasher} This hasher.
             *
             * @example
             *
             *     hasher.update('message');
             *     hasher.update(wordArray);
             */
            update: function (messageUpdate) {
                // Append
                this._append(messageUpdate);

                // Update the hash
                this._process();

                // Chainable
                return this;
            },

            /**
             * Finalizes the hash computation.
             * Note that the finalize operation is effectively a destructive, read-once operation.
             *
             * @param {WordArray|string} messageUpdate (Optional) A final message update.
             *
             * @return {WordArray} The hash.
             *
             * @example
             *
             *     var hash = hasher.finalize();
             *     var hash = hasher.finalize('message');
             *     var hash = hasher.finalize(wordArray);
             */
            finalize: function (messageUpdate) {
                // Final message update
                if (messageUpdate) {
                    this._append(messageUpdate);
                }

                // Perform concrete-hasher logic
                var hash = this._doFinalize();

                return hash;
            },

            blockSize: 512/32,

            /**
             * Creates a shortcut function to a hasher's object interface.
             *
             * @param {Hasher} hasher The hasher to create a helper for.
             *
             * @return {Function} The shortcut function.
             *
             * @static
             *
             * @example
             *
             *     var SHA256 = CryptoJS.lib.Hasher._createHelper(CryptoJS.algo.SHA256);
             */
            _createHelper: function (hasher) {
                return function (message, cfg) {
                    return new hasher.init(cfg).finalize(message);
                };
            },

            /**
             * Creates a shortcut function to the HMAC's object interface.
             *
             * @param {Hasher} hasher The hasher to use in this HMAC helper.
             *
             * @return {Function} The shortcut function.
             *
             * @static
             *
             * @example
             *
             *     var HmacSHA256 = CryptoJS.lib.Hasher._createHmacHelper(CryptoJS.algo.SHA256);
             */
            _createHmacHelper: function (hasher) {
                return function (message, key) {
                    return new C_algo.HMAC.init(hasher, key).finalize(message);
                };
            }
        });

        /**
         * Algorithm namespace.
         */
        var C_algo = C.algo = {};

        return C;
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var C_enc = C.enc;

        /**
         * Base64 encoding strategy.
         */
        var Base64 = C_enc.Base64 = {
            /**
             * Converts a word array to a Base64 string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The Base64 string.
             *
             * @static
             *
             * @example
             *
             *     var base64String = CryptoJS.enc.Base64.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;
                var map = this._map;

                // Clamp excess bits
                wordArray.clamp();

                // Convert
                var base64Chars = [];
                for (var i = 0; i < sigBytes; i += 3) {
                    var byte1 = (words[i >>> 2]       >>> (24 - (i % 4) * 8))       & 0xff;
                    var byte2 = (words[(i + 1) >>> 2] >>> (24 - ((i + 1) % 4) * 8)) & 0xff;
                    var byte3 = (words[(i + 2) >>> 2] >>> (24 - ((i + 2) % 4) * 8)) & 0xff;

                    var triplet = (byte1 << 16) | (byte2 << 8) | byte3;

                    for (var j = 0; (j < 4) && (i + j * 0.75 < sigBytes); j++) {
                        base64Chars.push(map.charAt((triplet >>> (6 * (3 - j))) & 0x3f));
                    }
                }

                // Add padding
                var paddingChar = map.charAt(64);
                if (paddingChar) {
                    while (base64Chars.length % 4) {
                        base64Chars.push(paddingChar);
                    }
                }

                return base64Chars.join('');
            },

            /**
             * Converts a Base64 string to a word array.
             *
             * @param {string} base64Str The Base64 string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Base64.parse(base64String);
             */
            parse: function (base64Str) {
                // Shortcuts
                var base64StrLength = base64Str.length;
                var map = this._map;
                var reverseMap = this._reverseMap;

                if (!reverseMap) {
                    reverseMap = this._reverseMap = [];
                    for (var j = 0; j < map.length; j++) {
                        reverseMap[map.charCodeAt(j)] = j;
                    }
                }

                // Ignore padding
                var paddingChar = map.charAt(64);
                if (paddingChar) {
                    var paddingIndex = base64Str.indexOf(paddingChar);
                    if (paddingIndex !== -1) {
                        base64StrLength = paddingIndex;
                    }
                }

                // Convert
                return parseLoop(base64Str, base64StrLength, reverseMap);

            },

            _map: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
        };

        function parseLoop(base64Str, base64StrLength, reverseMap) {
            var words = [];
            var nBytes = 0;
            for (var i = 0; i < base64StrLength; i++) {
                if (i % 4) {
                    var bits1 = reverseMap[base64Str.charCodeAt(i - 1)] << ((i % 4) * 2);
                    var bits2 = reverseMap[base64Str.charCodeAt(i)] >>> (6 - (i % 4) * 2);
                    words[nBytes >>> 2] |= (bits1 | bits2) << (24 - (nBytes % 4) * 8);
                    nBytes++;
                }
            }
            return WordArray.create(words, nBytes);
        }
    }());


    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Constants table
        var T = [];

        // Compute constants
        (function () {
            for (var i = 0; i < 64; i++) {
                T[i] = (Math.abs(Math.sin(i + 1)) * 0x100000000) | 0;
            }
        }());

        /**
         * MD5 hash algorithm.
         */
        var MD5 = C_algo.MD5 = Hasher.extend({
            _doReset: function () {
                this._hash = new WordArray.init([
                    0x67452301, 0xefcdab89,
                    0x98badcfe, 0x10325476
                ]);
            },

            _doProcessBlock: function (M, offset) {
                // Swap endian
                for (var i = 0; i < 16; i++) {
                    // Shortcuts
                    var offset_i = offset + i;
                    var M_offset_i = M[offset_i];

                    M[offset_i] = (
                        (((M_offset_i << 8)  | (M_offset_i >>> 24)) & 0x00ff00ff) |
                        (((M_offset_i << 24) | (M_offset_i >>> 8))  & 0xff00ff00)
                    );
                }

                // Shortcuts
                var H = this._hash.words;

                var M_offset_0  = M[offset + 0];
                var M_offset_1  = M[offset + 1];
                var M_offset_2  = M[offset + 2];
                var M_offset_3  = M[offset + 3];
                var M_offset_4  = M[offset + 4];
                var M_offset_5  = M[offset + 5];
                var M_offset_6  = M[offset + 6];
                var M_offset_7  = M[offset + 7];
                var M_offset_8  = M[offset + 8];
                var M_offset_9  = M[offset + 9];
                var M_offset_10 = M[offset + 10];
                var M_offset_11 = M[offset + 11];
                var M_offset_12 = M[offset + 12];
                var M_offset_13 = M[offset + 13];
                var M_offset_14 = M[offset + 14];
                var M_offset_15 = M[offset + 15];

                // Working varialbes
                var a = H[0];
                var b = H[1];
                var c = H[2];
                var d = H[3];

                // Computation
                a = FF(a, b, c, d, M_offset_0,  7,  T[0]);
                d = FF(d, a, b, c, M_offset_1,  12, T[1]);
                c = FF(c, d, a, b, M_offset_2,  17, T[2]);
                b = FF(b, c, d, a, M_offset_3,  22, T[3]);
                a = FF(a, b, c, d, M_offset_4,  7,  T[4]);
                d = FF(d, a, b, c, M_offset_5,  12, T[5]);
                c = FF(c, d, a, b, M_offset_6,  17, T[6]);
                b = FF(b, c, d, a, M_offset_7,  22, T[7]);
                a = FF(a, b, c, d, M_offset_8,  7,  T[8]);
                d = FF(d, a, b, c, M_offset_9,  12, T[9]);
                c = FF(c, d, a, b, M_offset_10, 17, T[10]);
                b = FF(b, c, d, a, M_offset_11, 22, T[11]);
                a = FF(a, b, c, d, M_offset_12, 7,  T[12]);
                d = FF(d, a, b, c, M_offset_13, 12, T[13]);
                c = FF(c, d, a, b, M_offset_14, 17, T[14]);
                b = FF(b, c, d, a, M_offset_15, 22, T[15]);

                a = GG(a, b, c, d, M_offset_1,  5,  T[16]);
                d = GG(d, a, b, c, M_offset_6,  9,  T[17]);
                c = GG(c, d, a, b, M_offset_11, 14, T[18]);
                b = GG(b, c, d, a, M_offset_0,  20, T[19]);
                a = GG(a, b, c, d, M_offset_5,  5,  T[20]);
                d = GG(d, a, b, c, M_offset_10, 9,  T[21]);
                c = GG(c, d, a, b, M_offset_15, 14, T[22]);
                b = GG(b, c, d, a, M_offset_4,  20, T[23]);
                a = GG(a, b, c, d, M_offset_9,  5,  T[24]);
                d = GG(d, a, b, c, M_offset_14, 9,  T[25]);
                c = GG(c, d, a, b, M_offset_3,  14, T[26]);
                b = GG(b, c, d, a, M_offset_8,  20, T[27]);
                a = GG(a, b, c, d, M_offset_13, 5,  T[28]);
                d = GG(d, a, b, c, M_offset_2,  9,  T[29]);
                c = GG(c, d, a, b, M_offset_7,  14, T[30]);
                b = GG(b, c, d, a, M_offset_12, 20, T[31]);

                a = HH(a, b, c, d, M_offset_5,  4,  T[32]);
                d = HH(d, a, b, c, M_offset_8,  11, T[33]);
                c = HH(c, d, a, b, M_offset_11, 16, T[34]);
                b = HH(b, c, d, a, M_offset_14, 23, T[35]);
                a = HH(a, b, c, d, M_offset_1,  4,  T[36]);
                d = HH(d, a, b, c, M_offset_4,  11, T[37]);
                c = HH(c, d, a, b, M_offset_7,  16, T[38]);
                b = HH(b, c, d, a, M_offset_10, 23, T[39]);
                a = HH(a, b, c, d, M_offset_13, 4,  T[40]);
                d = HH(d, a, b, c, M_offset_0,  11, T[41]);
                c = HH(c, d, a, b, M_offset_3,  16, T[42]);
                b = HH(b, c, d, a, M_offset_6,  23, T[43]);
                a = HH(a, b, c, d, M_offset_9,  4,  T[44]);
                d = HH(d, a, b, c, M_offset_12, 11, T[45]);
                c = HH(c, d, a, b, M_offset_15, 16, T[46]);
                b = HH(b, c, d, a, M_offset_2,  23, T[47]);

                a = II(a, b, c, d, M_offset_0,  6,  T[48]);
                d = II(d, a, b, c, M_offset_7,  10, T[49]);
                c = II(c, d, a, b, M_offset_14, 15, T[50]);
                b = II(b, c, d, a, M_offset_5,  21, T[51]);
                a = II(a, b, c, d, M_offset_12, 6,  T[52]);
                d = II(d, a, b, c, M_offset_3,  10, T[53]);
                c = II(c, d, a, b, M_offset_10, 15, T[54]);
                b = II(b, c, d, a, M_offset_1,  21, T[55]);
                a = II(a, b, c, d, M_offset_8,  6,  T[56]);
                d = II(d, a, b, c, M_offset_15, 10, T[57]);
                c = II(c, d, a, b, M_offset_6,  15, T[58]);
                b = II(b, c, d, a, M_offset_13, 21, T[59]);
                a = II(a, b, c, d, M_offset_4,  6,  T[60]);
                d = II(d, a, b, c, M_offset_11, 10, T[61]);
                c = II(c, d, a, b, M_offset_2,  15, T[62]);
                b = II(b, c, d, a, M_offset_9,  21, T[63]);

                // Intermediate hash value
                H[0] = (H[0] + a) | 0;
                H[1] = (H[1] + b) | 0;
                H[2] = (H[2] + c) | 0;
                H[3] = (H[3] + d) | 0;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);

                var nBitsTotalH = Math.floor(nBitsTotal / 0x100000000);
                var nBitsTotalL = nBitsTotal;
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 15] = (
                    (((nBitsTotalH << 8)  | (nBitsTotalH >>> 24)) & 0x00ff00ff) |
                    (((nBitsTotalH << 24) | (nBitsTotalH >>> 8))  & 0xff00ff00)
                );
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = (
                    (((nBitsTotalL << 8)  | (nBitsTotalL >>> 24)) & 0x00ff00ff) |
                    (((nBitsTotalL << 24) | (nBitsTotalL >>> 8))  & 0xff00ff00)
                );

                data.sigBytes = (dataWords.length + 1) * 4;

                // Hash final blocks
                this._process();

                // Shortcuts
                var hash = this._hash;
                var H = hash.words;

                // Swap endian
                for (var i = 0; i < 4; i++) {
                    // Shortcut
                    var H_i = H[i];

                    H[i] = (((H_i << 8)  | (H_i >>> 24)) & 0x00ff00ff) |
                        (((H_i << 24) | (H_i >>> 8))  & 0xff00ff00);
                }

                // Return final computed hash
                return hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });

        function FF(a, b, c, d, x, s, t) {
            var n = a + ((b & c) | (~b & d)) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        function GG(a, b, c, d, x, s, t) {
            var n = a + ((b & d) | (c & ~d)) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        function HH(a, b, c, d, x, s, t) {
            var n = a + (b ^ c ^ d) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        function II(a, b, c, d, x, s, t) {
            var n = a + (c ^ (b | ~d)) + x + t;
            return ((n << s) | (n >>> (32 - s))) + b;
        }

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.MD5('message');
         *     var hash = CryptoJS.MD5(wordArray);
         */
        C.MD5 = Hasher._createHelper(MD5);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacMD5(message, key);
         */
        C.HmacMD5 = Hasher._createHmacHelper(MD5);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Reusable object
        var W = [];

        /**
         * SHA-1 hash algorithm.
         */
        var SHA1 = C_algo.SHA1 = Hasher.extend({
            _doReset: function () {
                this._hash = new WordArray.init([
                    0x67452301, 0xefcdab89,
                    0x98badcfe, 0x10325476,
                    0xc3d2e1f0
                ]);
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var H = this._hash.words;

                // Working variables
                var a = H[0];
                var b = H[1];
                var c = H[2];
                var d = H[3];
                var e = H[4];

                // Computation
                for (var i = 0; i < 80; i++) {
                    if (i < 16) {
                        W[i] = M[offset + i] | 0;
                    } else {
                        var n = W[i - 3] ^ W[i - 8] ^ W[i - 14] ^ W[i - 16];
                        W[i] = (n << 1) | (n >>> 31);
                    }

                    var t = ((a << 5) | (a >>> 27)) + e + W[i];
                    if (i < 20) {
                        t += ((b & c) | (~b & d)) + 0x5a827999;
                    } else if (i < 40) {
                        t += (b ^ c ^ d) + 0x6ed9eba1;
                    } else if (i < 60) {
                        t += ((b & c) | (b & d) | (c & d)) - 0x70e44324;
                    } else /* if (i < 80) */ {
                        t += (b ^ c ^ d) - 0x359d3e2a;
                    }

                    e = d;
                    d = c;
                    c = (b << 30) | (b >>> 2);
                    b = a;
                    a = t;
                }

                // Intermediate hash value
                H[0] = (H[0] + a) | 0;
                H[1] = (H[1] + b) | 0;
                H[2] = (H[2] + c) | 0;
                H[3] = (H[3] + d) | 0;
                H[4] = (H[4] + e) | 0;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = Math.floor(nBitsTotal / 0x100000000);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 15] = nBitsTotal;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Return final computed hash
                return this._hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA1('message');
         *     var hash = CryptoJS.SHA1(wordArray);
         */
        C.SHA1 = Hasher._createHelper(SHA1);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA1(message, key);
         */
        C.HmacSHA1 = Hasher._createHmacHelper(SHA1);
    }());


    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Initialization and round constants tables
        var H = [];
        var K = [];

        // Compute constants
        (function () {
            function isPrime(n) {
                var sqrtN = Math.sqrt(n);
                for (var factor = 2; factor <= sqrtN; factor++) {
                    if (!(n % factor)) {
                        return false;
                    }
                }

                return true;
            }

            function getFractionalBits(n) {
                return ((n - (n | 0)) * 0x100000000) | 0;
            }

            var n = 2;
            var nPrime = 0;
            while (nPrime < 64) {
                if (isPrime(n)) {
                    if (nPrime < 8) {
                        H[nPrime] = getFractionalBits(Math.pow(n, 1 / 2));
                    }
                    K[nPrime] = getFractionalBits(Math.pow(n, 1 / 3));

                    nPrime++;
                }

                n++;
            }
        }());

        // Reusable object
        var W = [];

        /**
         * SHA-256 hash algorithm.
         */
        var SHA256 = C_algo.SHA256 = Hasher.extend({
            _doReset: function () {
                this._hash = new WordArray.init(H.slice(0));
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var H = this._hash.words;

                // Working variables
                var a = H[0];
                var b = H[1];
                var c = H[2];
                var d = H[3];
                var e = H[4];
                var f = H[5];
                var g = H[6];
                var h = H[7];

                // Computation
                for (var i = 0; i < 64; i++) {
                    if (i < 16) {
                        W[i] = M[offset + i] | 0;
                    } else {
                        var gamma0x = W[i - 15];
                        var gamma0  = ((gamma0x << 25) | (gamma0x >>> 7))  ^
                            ((gamma0x << 14) | (gamma0x >>> 18)) ^
                            (gamma0x >>> 3);

                        var gamma1x = W[i - 2];
                        var gamma1  = ((gamma1x << 15) | (gamma1x >>> 17)) ^
                            ((gamma1x << 13) | (gamma1x >>> 19)) ^
                            (gamma1x >>> 10);

                        W[i] = gamma0 + W[i - 7] + gamma1 + W[i - 16];
                    }

                    var ch  = (e & f) ^ (~e & g);
                    var maj = (a & b) ^ (a & c) ^ (b & c);

                    var sigma0 = ((a << 30) | (a >>> 2)) ^ ((a << 19) | (a >>> 13)) ^ ((a << 10) | (a >>> 22));
                    var sigma1 = ((e << 26) | (e >>> 6)) ^ ((e << 21) | (e >>> 11)) ^ ((e << 7)  | (e >>> 25));

                    var t1 = h + sigma1 + ch + K[i] + W[i];
                    var t2 = sigma0 + maj;

                    h = g;
                    g = f;
                    f = e;
                    e = (d + t1) | 0;
                    d = c;
                    c = b;
                    b = a;
                    a = (t1 + t2) | 0;
                }

                // Intermediate hash value
                H[0] = (H[0] + a) | 0;
                H[1] = (H[1] + b) | 0;
                H[2] = (H[2] + c) | 0;
                H[3] = (H[3] + d) | 0;
                H[4] = (H[4] + e) | 0;
                H[5] = (H[5] + f) | 0;
                H[6] = (H[6] + g) | 0;
                H[7] = (H[7] + h) | 0;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = Math.floor(nBitsTotal / 0x100000000);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 15] = nBitsTotal;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Return final computed hash
                return this._hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA256('message');
         *     var hash = CryptoJS.SHA256(wordArray);
         */
        C.SHA256 = Hasher._createHelper(SHA256);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA256(message, key);
         */
        C.HmacSHA256 = Hasher._createHmacHelper(SHA256);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var C_enc = C.enc;

        /**
         * UTF-16 BE encoding strategy.
         */
        var Utf16BE = C_enc.Utf16 = C_enc.Utf16BE = {
            /**
             * Converts a word array to a UTF-16 BE string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The UTF-16 BE string.
             *
             * @static
             *
             * @example
             *
             *     var utf16String = CryptoJS.enc.Utf16.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var utf16Chars = [];
                for (var i = 0; i < sigBytes; i += 2) {
                    var codePoint = (words[i >>> 2] >>> (16 - (i % 4) * 8)) & 0xffff;
                    utf16Chars.push(String.fromCharCode(codePoint));
                }

                return utf16Chars.join('');
            },

            /**
             * Converts a UTF-16 BE string to a word array.
             *
             * @param {string} utf16Str The UTF-16 BE string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Utf16.parse(utf16String);
             */
            parse: function (utf16Str) {
                // Shortcut
                var utf16StrLength = utf16Str.length;

                // Convert
                var words = [];
                for (var i = 0; i < utf16StrLength; i++) {
                    words[i >>> 1] |= utf16Str.charCodeAt(i) << (16 - (i % 2) * 16);
                }

                return WordArray.create(words, utf16StrLength * 2);
            }
        };

        /**
         * UTF-16 LE encoding strategy.
         */
        C_enc.Utf16LE = {
            /**
             * Converts a word array to a UTF-16 LE string.
             *
             * @param {WordArray} wordArray The word array.
             *
             * @return {string} The UTF-16 LE string.
             *
             * @static
             *
             * @example
             *
             *     var utf16Str = CryptoJS.enc.Utf16LE.stringify(wordArray);
             */
            stringify: function (wordArray) {
                // Shortcuts
                var words = wordArray.words;
                var sigBytes = wordArray.sigBytes;

                // Convert
                var utf16Chars = [];
                for (var i = 0; i < sigBytes; i += 2) {
                    var codePoint = swapEndian((words[i >>> 2] >>> (16 - (i % 4) * 8)) & 0xffff);
                    utf16Chars.push(String.fromCharCode(codePoint));
                }

                return utf16Chars.join('');
            },

            /**
             * Converts a UTF-16 LE string to a word array.
             *
             * @param {string} utf16Str The UTF-16 LE string.
             *
             * @return {WordArray} The word array.
             *
             * @static
             *
             * @example
             *
             *     var wordArray = CryptoJS.enc.Utf16LE.parse(utf16Str);
             */
            parse: function (utf16Str) {
                // Shortcut
                var utf16StrLength = utf16Str.length;

                // Convert
                var words = [];
                for (var i = 0; i < utf16StrLength; i++) {
                    words[i >>> 1] |= swapEndian(utf16Str.charCodeAt(i) << (16 - (i % 2) * 16));
                }

                return WordArray.create(words, utf16StrLength * 2);
            }
        };

        function swapEndian(word) {
            return ((word << 8) & 0xff00ff00) | ((word >>> 8) & 0x00ff00ff);
        }
    }());


    (function () {
        // Check if typed arrays are supported
        if (typeof ArrayBuffer != 'function') {
            return;
        }

        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;

        // Reference original init
        var superInit = WordArray.init;

        // Augment WordArray.init to handle typed arrays
        var subInit = WordArray.init = function (typedArray) {
            // Convert buffers to uint8
            if (typedArray instanceof ArrayBuffer) {
                typedArray = new Uint8Array(typedArray);
            }

            // Convert other array views to uint8
            if (
                typedArray instanceof Int8Array ||
                (typeof Uint8ClampedArray !== "undefined" && typedArray instanceof Uint8ClampedArray) ||
                typedArray instanceof Int16Array ||
                typedArray instanceof Uint16Array ||
                typedArray instanceof Int32Array ||
                typedArray instanceof Uint32Array ||
                typedArray instanceof Float32Array ||
                typedArray instanceof Float64Array
            ) {
                typedArray = new Uint8Array(typedArray.buffer, typedArray.byteOffset, typedArray.byteLength);
            }

            // Handle Uint8Array
            if (typedArray instanceof Uint8Array) {
                // Shortcut
                var typedArrayByteLength = typedArray.byteLength;

                // Extract bytes
                var words = [];
                for (var i = 0; i < typedArrayByteLength; i++) {
                    words[i >>> 2] |= typedArray[i] << (24 - (i % 4) * 8);
                }

                // Initialize this word array
                superInit.call(this, words, typedArrayByteLength);
            } else {
                // Else call normal init
                superInit.apply(this, arguments);
            }
        };

        subInit.prototype = WordArray;
    }());


    /** @preserve
     (c) 2012 by Cédric Mesnil. All rights reserved.

     Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

     - Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
     - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

     THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
     */

    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_algo = C.algo;

        // Constants table
        var _zl = WordArray.create([
            0,  1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12, 13, 14, 15,
            7,  4, 13,  1, 10,  6, 15,  3, 12,  0,  9,  5,  2, 14, 11,  8,
            3, 10, 14,  4,  9, 15,  8,  1,  2,  7,  0,  6, 13, 11,  5, 12,
            1,  9, 11, 10,  0,  8, 12,  4, 13,  3,  7, 15, 14,  5,  6,  2,
            4,  0,  5,  9,  7, 12,  2, 10, 14,  1,  3,  8, 11,  6, 15, 13]);
        var _zr = WordArray.create([
            5, 14,  7,  0,  9,  2, 11,  4, 13,  6, 15,  8,  1, 10,  3, 12,
            6, 11,  3,  7,  0, 13,  5, 10, 14, 15,  8, 12,  4,  9,  1,  2,
            15,  5,  1,  3,  7, 14,  6,  9, 11,  8, 12,  2, 10,  0,  4, 13,
            8,  6,  4,  1,  3, 11, 15,  0,  5, 12,  2, 13,  9,  7, 10, 14,
            12, 15, 10,  4,  1,  5,  8,  7,  6,  2, 13, 14,  0,  3,  9, 11]);
        var _sl = WordArray.create([
            11, 14, 15, 12,  5,  8,  7,  9, 11, 13, 14, 15,  6,  7,  9,  8,
            7, 6,   8, 13, 11,  9,  7, 15,  7, 12, 15,  9, 11,  7, 13, 12,
            11, 13,  6,  7, 14,  9, 13, 15, 14,  8, 13,  6,  5, 12,  7,  5,
            11, 12, 14, 15, 14, 15,  9,  8,  9, 14,  5,  6,  8,  6,  5, 12,
            9, 15,  5, 11,  6,  8, 13, 12,  5, 12, 13, 14, 11,  8,  5,  6 ]);
        var _sr = WordArray.create([
            8,  9,  9, 11, 13, 15, 15,  5,  7,  7,  8, 11, 14, 14, 12,  6,
            9, 13, 15,  7, 12,  8,  9, 11,  7,  7, 12,  7,  6, 15, 13, 11,
            9,  7, 15, 11,  8,  6,  6, 14, 12, 13,  5, 14, 13, 13,  7,  5,
            15,  5,  8, 11, 14, 14,  6, 14,  6,  9, 12,  9, 12,  5, 15,  8,
            8,  5, 12,  9, 12,  5, 14,  6,  8, 13,  6,  5, 15, 13, 11, 11 ]);

        var _hl =  WordArray.create([ 0x00000000, 0x5A827999, 0x6ED9EBA1, 0x8F1BBCDC, 0xA953FD4E]);
        var _hr =  WordArray.create([ 0x50A28BE6, 0x5C4DD124, 0x6D703EF3, 0x7A6D76E9, 0x00000000]);

        /**
         * RIPEMD160 hash algorithm.
         */
        var RIPEMD160 = C_algo.RIPEMD160 = Hasher.extend({
            _doReset: function () {
                this._hash  = WordArray.create([0x67452301, 0xEFCDAB89, 0x98BADCFE, 0x10325476, 0xC3D2E1F0]);
            },

            _doProcessBlock: function (M, offset) {

                // Swap endian
                for (var i = 0; i < 16; i++) {
                    // Shortcuts
                    var offset_i = offset + i;
                    var M_offset_i = M[offset_i];

                    // Swap
                    M[offset_i] = (
                        (((M_offset_i << 8)  | (M_offset_i >>> 24)) & 0x00ff00ff) |
                        (((M_offset_i << 24) | (M_offset_i >>> 8))  & 0xff00ff00)
                    );
                }
                // Shortcut
                var H  = this._hash.words;
                var hl = _hl.words;
                var hr = _hr.words;
                var zl = _zl.words;
                var zr = _zr.words;
                var sl = _sl.words;
                var sr = _sr.words;

                // Working variables
                var al, bl, cl, dl, el;
                var ar, br, cr, dr, er;

                ar = al = H[0];
                br = bl = H[1];
                cr = cl = H[2];
                dr = dl = H[3];
                er = el = H[4];
                // Computation
                var t;
                for (var i = 0; i < 80; i += 1) {
                    t = (al +  M[offset+zl[i]])|0;
                    if (i<16){
                        t +=  f1(bl,cl,dl) + hl[0];
                    } else if (i<32) {
                        t +=  f2(bl,cl,dl) + hl[1];
                    } else if (i<48) {
                        t +=  f3(bl,cl,dl) + hl[2];
                    } else if (i<64) {
                        t +=  f4(bl,cl,dl) + hl[3];
                    } else {// if (i<80) {
                        t +=  f5(bl,cl,dl) + hl[4];
                    }
                    t = t|0;
                    t =  rotl(t,sl[i]);
                    t = (t+el)|0;
                    al = el;
                    el = dl;
                    dl = rotl(cl, 10);
                    cl = bl;
                    bl = t;

                    t = (ar + M[offset+zr[i]])|0;
                    if (i<16){
                        t +=  f5(br,cr,dr) + hr[0];
                    } else if (i<32) {
                        t +=  f4(br,cr,dr) + hr[1];
                    } else if (i<48) {
                        t +=  f3(br,cr,dr) + hr[2];
                    } else if (i<64) {
                        t +=  f2(br,cr,dr) + hr[3];
                    } else {// if (i<80) {
                        t +=  f1(br,cr,dr) + hr[4];
                    }
                    t = t|0;
                    t =  rotl(t,sr[i]) ;
                    t = (t+er)|0;
                    ar = er;
                    er = dr;
                    dr = rotl(cr, 10);
                    cr = br;
                    br = t;
                }
                // Intermediate hash value
                t    = (H[1] + cl + dr)|0;
                H[1] = (H[2] + dl + er)|0;
                H[2] = (H[3] + el + ar)|0;
                H[3] = (H[4] + al + br)|0;
                H[4] = (H[0] + bl + cr)|0;
                H[0] =  t;
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 64) >>> 9) << 4) + 14] = (
                    (((nBitsTotal << 8)  | (nBitsTotal >>> 24)) & 0x00ff00ff) |
                    (((nBitsTotal << 24) | (nBitsTotal >>> 8))  & 0xff00ff00)
                );
                data.sigBytes = (dataWords.length + 1) * 4;

                // Hash final blocks
                this._process();

                // Shortcuts
                var hash = this._hash;
                var H = hash.words;

                // Swap endian
                for (var i = 0; i < 5; i++) {
                    // Shortcut
                    var H_i = H[i];

                    // Swap
                    H[i] = (((H_i << 8)  | (H_i >>> 24)) & 0x00ff00ff) |
                        (((H_i << 24) | (H_i >>> 8))  & 0xff00ff00);
                }

                // Return final computed hash
                return hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            }
        });


        function f1(x, y, z) {
            return ((x) ^ (y) ^ (z));

        }

        function f2(x, y, z) {
            return (((x)&(y)) | ((~x)&(z)));
        }

        function f3(x, y, z) {
            return (((x) | (~(y))) ^ (z));
        }

        function f4(x, y, z) {
            return (((x) & (z)) | ((y)&(~(z))));
        }

        function f5(x, y, z) {
            return ((x) ^ ((y) |(~(z))));

        }

        function rotl(x,n) {
            return (x<<n) | (x>>>(32-n));
        }


        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.RIPEMD160('message');
         *     var hash = CryptoJS.RIPEMD160(wordArray);
         */
        C.RIPEMD160 = Hasher._createHelper(RIPEMD160);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacRIPEMD160(message, key);
         */
        C.HmacRIPEMD160 = Hasher._createHmacHelper(RIPEMD160);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var C_enc = C.enc;
        var Utf8 = C_enc.Utf8;
        var C_algo = C.algo;

        /**
         * HMAC algorithm.
         */
        var HMAC = C_algo.HMAC = Base.extend({
            /**
             * Initializes a newly created HMAC.
             *
             * @param {Hasher} hasher The hash algorithm to use.
             * @param {WordArray|string} key The secret key.
             *
             * @example
             *
             *     var hmacHasher = CryptoJS.algo.HMAC.create(CryptoJS.algo.SHA256, key);
             */
            init: function (hasher, key) {
                // Init hasher
                hasher = this._hasher = new hasher.init();

                // Convert string to WordArray, else assume WordArray already
                if (typeof key == 'string') {
                    key = Utf8.parse(key);
                }

                // Shortcuts
                var hasherBlockSize = hasher.blockSize;
                var hasherBlockSizeBytes = hasherBlockSize * 4;

                // Allow arbitrary length keys
                if (key.sigBytes > hasherBlockSizeBytes) {
                    key = hasher.finalize(key);
                }

                // Clamp excess bits
                key.clamp();

                // Clone key for inner and outer pads
                var oKey = this._oKey = key.clone();
                var iKey = this._iKey = key.clone();

                // Shortcuts
                var oKeyWords = oKey.words;
                var iKeyWords = iKey.words;

                // XOR keys with pad constants
                for (var i = 0; i < hasherBlockSize; i++) {
                    oKeyWords[i] ^= 0x5c5c5c5c;
                    iKeyWords[i] ^= 0x36363636;
                }
                oKey.sigBytes = iKey.sigBytes = hasherBlockSizeBytes;

                // Set initial values
                this.reset();
            },

            /**
             * Resets this HMAC to its initial state.
             *
             * @example
             *
             *     hmacHasher.reset();
             */
            reset: function () {
                // Shortcut
                var hasher = this._hasher;

                // Reset
                hasher.reset();
                hasher.update(this._iKey);
            },

            /**
             * Updates this HMAC with a message.
             *
             * @param {WordArray|string} messageUpdate The message to append.
             *
             * @return {HMAC} This HMAC instance.
             *
             * @example
             *
             *     hmacHasher.update('message');
             *     hmacHasher.update(wordArray);
             */
            update: function (messageUpdate) {
                this._hasher.update(messageUpdate);

                // Chainable
                return this;
            },

            /**
             * Finalizes the HMAC computation.
             * Note that the finalize operation is effectively a destructive, read-once operation.
             *
             * @param {WordArray|string} messageUpdate (Optional) A final message update.
             *
             * @return {WordArray} The HMAC.
             *
             * @example
             *
             *     var hmac = hmacHasher.finalize();
             *     var hmac = hmacHasher.finalize('message');
             *     var hmac = hmacHasher.finalize(wordArray);
             */
            finalize: function (messageUpdate) {
                // Shortcut
                var hasher = this._hasher;

                // Compute HMAC
                var innerHash = hasher.finalize(messageUpdate);
                hasher.reset();
                var hmac = hasher.finalize(this._oKey.clone().concat(innerHash));

                return hmac;
            }
        });
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var WordArray = C_lib.WordArray;
        var C_algo = C.algo;
        var SHA1 = C_algo.SHA1;
        var HMAC = C_algo.HMAC;

        /**
         * Password-Based Key Derivation Function 2 algorithm.
         */
        var PBKDF2 = C_algo.PBKDF2 = Base.extend({
            /**
             * Configuration options.
             *
             * @property {number} keySize The key size in words to generate. Default: 4 (128 bits)
             * @property {Hasher} hasher The hasher to use. Default: SHA1
             * @property {number} iterations The number of iterations to perform. Default: 1
             */
            cfg: Base.extend({
                keySize: 128/32,
                hasher: SHA1,
                iterations: 1
            }),

            /**
             * Initializes a newly created key derivation function.
             *
             * @param {Object} cfg (Optional) The configuration options to use for the derivation.
             *
             * @example
             *
             *     var kdf = CryptoJS.algo.PBKDF2.create();
             *     var kdf = CryptoJS.algo.PBKDF2.create({ keySize: 8 });
             *     var kdf = CryptoJS.algo.PBKDF2.create({ keySize: 8, iterations: 1000 });
             */
            init: function (cfg) {
                this.cfg = this.cfg.extend(cfg);
            },

            /**
             * Computes the Password-Based Key Derivation Function 2.
             *
             * @param {WordArray|string} password The password.
             * @param {WordArray|string} salt A salt.
             *
             * @return {WordArray} The derived key.
             *
             * @example
             *
             *     var key = kdf.compute(password, salt);
             */
            compute: function (password, salt) {
                // Shortcut
                var cfg = this.cfg;

                // Init HMAC
                var hmac = HMAC.create(cfg.hasher, password);

                // Initial values
                var derivedKey = WordArray.create();
                var blockIndex = WordArray.create([0x00000001]);

                // Shortcuts
                var derivedKeyWords = derivedKey.words;
                var blockIndexWords = blockIndex.words;
                var keySize = cfg.keySize;
                var iterations = cfg.iterations;

                // Generate key
                while (derivedKeyWords.length < keySize) {
                    var block = hmac.update(salt).finalize(blockIndex);
                    hmac.reset();

                    // Shortcuts
                    var blockWords = block.words;
                    var blockWordsLength = blockWords.length;

                    // Iterations
                    var intermediate = block;
                    for (var i = 1; i < iterations; i++) {
                        intermediate = hmac.finalize(intermediate);
                        hmac.reset();

                        // Shortcut
                        var intermediateWords = intermediate.words;

                        // XOR intermediate with block
                        for (var j = 0; j < blockWordsLength; j++) {
                            blockWords[j] ^= intermediateWords[j];
                        }
                    }

                    derivedKey.concat(block);
                    blockIndexWords[0]++;
                }
                derivedKey.sigBytes = keySize * 4;

                return derivedKey;
            }
        });

        /**
         * Computes the Password-Based Key Derivation Function 2.
         *
         * @param {WordArray|string} password The password.
         * @param {WordArray|string} salt A salt.
         * @param {Object} cfg (Optional) The configuration options to use for this computation.
         *
         * @return {WordArray} The derived key.
         *
         * @static
         *
         * @example
         *
         *     var key = CryptoJS.PBKDF2(password, salt);
         *     var key = CryptoJS.PBKDF2(password, salt, { keySize: 8 });
         *     var key = CryptoJS.PBKDF2(password, salt, { keySize: 8, iterations: 1000 });
         */
        C.PBKDF2 = function (password, salt, cfg) {
            return PBKDF2.create(cfg).compute(password, salt);
        };
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var WordArray = C_lib.WordArray;
        var C_algo = C.algo;
        var MD5 = C_algo.MD5;

        /**
         * This key derivation function is meant to conform with EVP_BytesToKey.
         * www.openssl.org/docs/crypto/EVP_BytesToKey.html
         */
        var EvpKDF = C_algo.EvpKDF = Base.extend({
            /**
             * Configuration options.
             *
             * @property {number} keySize The key size in words to generate. Default: 4 (128 bits)
             * @property {Hasher} hasher The hash algorithm to use. Default: MD5
             * @property {number} iterations The number of iterations to perform. Default: 1
             */
            cfg: Base.extend({
                keySize: 128/32,
                hasher: MD5,
                iterations: 1
            }),

            /**
             * Initializes a newly created key derivation function.
             *
             * @param {Object} cfg (Optional) The configuration options to use for the derivation.
             *
             * @example
             *
             *     var kdf = CryptoJS.algo.EvpKDF.create();
             *     var kdf = CryptoJS.algo.EvpKDF.create({ keySize: 8 });
             *     var kdf = CryptoJS.algo.EvpKDF.create({ keySize: 8, iterations: 1000 });
             */
            init: function (cfg) {
                this.cfg = this.cfg.extend(cfg);
            },

            /**
             * Derives a key from a password.
             *
             * @param {WordArray|string} password The password.
             * @param {WordArray|string} salt A salt.
             *
             * @return {WordArray} The derived key.
             *
             * @example
             *
             *     var key = kdf.compute(password, salt);
             */
            compute: function (password, salt) {
                // Shortcut
                var cfg = this.cfg;

                // Init hasher
                var hasher = cfg.hasher.create();

                // Initial values
                var derivedKey = WordArray.create();

                // Shortcuts
                var derivedKeyWords = derivedKey.words;
                var keySize = cfg.keySize;
                var iterations = cfg.iterations;

                // Generate key
                while (derivedKeyWords.length < keySize) {
                    if (block) {
                        hasher.update(block);
                    }
                    var block = hasher.update(password).finalize(salt);
                    hasher.reset();

                    // Iterations
                    for (var i = 1; i < iterations; i++) {
                        block = hasher.finalize(block);
                        hasher.reset();
                    }

                    derivedKey.concat(block);
                }
                derivedKey.sigBytes = keySize * 4;

                return derivedKey;
            }
        });

        /**
         * Derives a key from a password.
         *
         * @param {WordArray|string} password The password.
         * @param {WordArray|string} salt A salt.
         * @param {Object} cfg (Optional) The configuration options to use for this computation.
         *
         * @return {WordArray} The derived key.
         *
         * @static
         *
         * @example
         *
         *     var key = CryptoJS.EvpKDF(password, salt);
         *     var key = CryptoJS.EvpKDF(password, salt, { keySize: 8 });
         *     var key = CryptoJS.EvpKDF(password, salt, { keySize: 8, iterations: 1000 });
         */
        C.EvpKDF = function (password, salt, cfg) {
            return EvpKDF.create(cfg).compute(password, salt);
        };
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var C_algo = C.algo;
        var SHA256 = C_algo.SHA256;

        /**
         * SHA-224 hash algorithm.
         */
        var SHA224 = C_algo.SHA224 = SHA256.extend({
            _doReset: function () {
                this._hash = new WordArray.init([
                    0xc1059ed8, 0x367cd507, 0x3070dd17, 0xf70e5939,
                    0xffc00b31, 0x68581511, 0x64f98fa7, 0xbefa4fa4
                ]);
            },

            _doFinalize: function () {
                var hash = SHA256._doFinalize.call(this);

                hash.sigBytes -= 4;

                return hash;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA224('message');
         *     var hash = CryptoJS.SHA224(wordArray);
         */
        C.SHA224 = SHA256._createHelper(SHA224);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA224(message, key);
         */
        C.HmacSHA224 = SHA256._createHmacHelper(SHA224);
    }());


    (function (undefined) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var X32WordArray = C_lib.WordArray;

        /**
         * x64 namespace.
         */
        var C_x64 = C.x64 = {};

        /**
         * A 64-bit word.
         */
        var X64Word = C_x64.Word = Base.extend({
            /**
             * Initializes a newly created 64-bit word.
             *
             * @param {number} high The high 32 bits.
             * @param {number} low The low 32 bits.
             *
             * @example
             *
             *     var x64Word = CryptoJS.x64.Word.create(0x00010203, 0x04050607);
             */
            init: function (high, low) {
                this.high = high;
                this.low = low;
            }

            /**
             * Bitwise NOTs this word.
             *
             * @return {X64Word} A new x64-Word object after negating.
             *
             * @example
             *
             *     var negated = x64Word.not();
             */
            // not: function () {
            // var high = ~this.high;
            // var low = ~this.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Bitwise ANDs this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to AND with this word.
             *
             * @return {X64Word} A new x64-Word object after ANDing.
             *
             * @example
             *
             *     var anded = x64Word.and(anotherX64Word);
             */
            // and: function (word) {
            // var high = this.high & word.high;
            // var low = this.low & word.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Bitwise ORs this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to OR with this word.
             *
             * @return {X64Word} A new x64-Word object after ORing.
             *
             * @example
             *
             *     var ored = x64Word.or(anotherX64Word);
             */
            // or: function (word) {
            // var high = this.high | word.high;
            // var low = this.low | word.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Bitwise XORs this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to XOR with this word.
             *
             * @return {X64Word} A new x64-Word object after XORing.
             *
             * @example
             *
             *     var xored = x64Word.xor(anotherX64Word);
             */
            // xor: function (word) {
            // var high = this.high ^ word.high;
            // var low = this.low ^ word.low;

            // return X64Word.create(high, low);
            // },

            /**
             * Shifts this word n bits to the left.
             *
             * @param {number} n The number of bits to shift.
             *
             * @return {X64Word} A new x64-Word object after shifting.
             *
             * @example
             *
             *     var shifted = x64Word.shiftL(25);
             */
            // shiftL: function (n) {
            // if (n < 32) {
            // var high = (this.high << n) | (this.low >>> (32 - n));
            // var low = this.low << n;
            // } else {
            // var high = this.low << (n - 32);
            // var low = 0;
            // }

            // return X64Word.create(high, low);
            // },

            /**
             * Shifts this word n bits to the right.
             *
             * @param {number} n The number of bits to shift.
             *
             * @return {X64Word} A new x64-Word object after shifting.
             *
             * @example
             *
             *     var shifted = x64Word.shiftR(7);
             */
            // shiftR: function (n) {
            // if (n < 32) {
            // var low = (this.low >>> n) | (this.high << (32 - n));
            // var high = this.high >>> n;
            // } else {
            // var low = this.high >>> (n - 32);
            // var high = 0;
            // }

            // return X64Word.create(high, low);
            // },

            /**
             * Rotates this word n bits to the left.
             *
             * @param {number} n The number of bits to rotate.
             *
             * @return {X64Word} A new x64-Word object after rotating.
             *
             * @example
             *
             *     var rotated = x64Word.rotL(25);
             */
            // rotL: function (n) {
            // return this.shiftL(n).or(this.shiftR(64 - n));
            // },

            /**
             * Rotates this word n bits to the right.
             *
             * @param {number} n The number of bits to rotate.
             *
             * @return {X64Word} A new x64-Word object after rotating.
             *
             * @example
             *
             *     var rotated = x64Word.rotR(7);
             */
            // rotR: function (n) {
            // return this.shiftR(n).or(this.shiftL(64 - n));
            // },

            /**
             * Adds this word with the passed word.
             *
             * @param {X64Word} word The x64-Word to add with this word.
             *
             * @return {X64Word} A new x64-Word object after adding.
             *
             * @example
             *
             *     var added = x64Word.add(anotherX64Word);
             */
            // add: function (word) {
            // var low = (this.low + word.low) | 0;
            // var carry = (low >>> 0) < (this.low >>> 0) ? 1 : 0;
            // var high = (this.high + word.high + carry) | 0;

            // return X64Word.create(high, low);
            // }
        });

        /**
         * An array of 64-bit words.
         *
         * @property {Array} words The array of CryptoJS.x64.Word objects.
         * @property {number} sigBytes The number of significant bytes in this word array.
         */
        var X64WordArray = C_x64.WordArray = Base.extend({
            /**
             * Initializes a newly created word array.
             *
             * @param {Array} words (Optional) An array of CryptoJS.x64.Word objects.
             * @param {number} sigBytes (Optional) The number of significant bytes in the words.
             *
             * @example
             *
             *     var wordArray = CryptoJS.x64.WordArray.create();
             *
             *     var wordArray = CryptoJS.x64.WordArray.create([
             *         CryptoJS.x64.Word.create(0x00010203, 0x04050607),
             *         CryptoJS.x64.Word.create(0x18191a1b, 0x1c1d1e1f)
             *     ]);
             *
             *     var wordArray = CryptoJS.x64.WordArray.create([
             *         CryptoJS.x64.Word.create(0x00010203, 0x04050607),
             *         CryptoJS.x64.Word.create(0x18191a1b, 0x1c1d1e1f)
             *     ], 10);
             */
            init: function (words, sigBytes) {
                words = this.words = words || [];

                if (sigBytes != undefined) {
                    this.sigBytes = sigBytes;
                } else {
                    this.sigBytes = words.length * 8;
                }
            },

            /**
             * Converts this 64-bit word array to a 32-bit word array.
             *
             * @return {CryptoJS.lib.WordArray} This word array's data as a 32-bit word array.
             *
             * @example
             *
             *     var x32WordArray = x64WordArray.toX32();
             */
            toX32: function () {
                // Shortcuts
                var x64Words = this.words;
                var x64WordsLength = x64Words.length;

                // Convert
                var x32Words = [];
                for (var i = 0; i < x64WordsLength; i++) {
                    var x64Word = x64Words[i];
                    x32Words.push(x64Word.high);
                    x32Words.push(x64Word.low);
                }

                return X32WordArray.create(x32Words, this.sigBytes);
            },

            /**
             * Creates a copy of this word array.
             *
             * @return {X64WordArray} The clone.
             *
             * @example
             *
             *     var clone = x64WordArray.clone();
             */
            clone: function () {
                var clone = Base.clone.call(this);

                // Clone "words" array
                var words = clone.words = this.words.slice(0);

                // Clone each X64Word object
                var wordsLength = words.length;
                for (var i = 0; i < wordsLength; i++) {
                    words[i] = words[i].clone();
                }

                return clone;
            }
        });
    }());


    (function (Math) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var Hasher = C_lib.Hasher;
        var C_x64 = C.x64;
        var X64Word = C_x64.Word;
        var C_algo = C.algo;

        // Constants tables
        var RHO_OFFSETS = [];
        var PI_INDEXES  = [];
        var ROUND_CONSTANTS = [];

        // Compute Constants
        (function () {
            // Compute rho offset constants
            var x = 1, y = 0;
            for (var t = 0; t < 24; t++) {
                RHO_OFFSETS[x + 5 * y] = ((t + 1) * (t + 2) / 2) % 64;

                var newX = y % 5;
                var newY = (2 * x + 3 * y) % 5;
                x = newX;
                y = newY;
            }

            // Compute pi index constants
            for (var x = 0; x < 5; x++) {
                for (var y = 0; y < 5; y++) {
                    PI_INDEXES[x + 5 * y] = y + ((2 * x + 3 * y) % 5) * 5;
                }
            }

            // Compute round constants
            var LFSR = 0x01;
            for (var i = 0; i < 24; i++) {
                var roundConstantMsw = 0;
                var roundConstantLsw = 0;

                for (var j = 0; j < 7; j++) {
                    if (LFSR & 0x01) {
                        var bitPosition = (1 << j) - 1;
                        if (bitPosition < 32) {
                            roundConstantLsw ^= 1 << bitPosition;
                        } else /* if (bitPosition >= 32) */ {
                            roundConstantMsw ^= 1 << (bitPosition - 32);
                        }
                    }

                    // Compute next LFSR
                    if (LFSR & 0x80) {
                        // Primitive polynomial over GF(2): x^8 + x^6 + x^5 + x^4 + 1
                        LFSR = (LFSR << 1) ^ 0x71;
                    } else {
                        LFSR <<= 1;
                    }
                }

                ROUND_CONSTANTS[i] = X64Word.create(roundConstantMsw, roundConstantLsw);
            }
        }());

        // Reusable objects for temporary values
        var T = [];
        (function () {
            for (var i = 0; i < 25; i++) {
                T[i] = X64Word.create();
            }
        }());

        /**
         * SHA-3 hash algorithm.
         */
        var SHA3 = C_algo.SHA3 = Hasher.extend({
            /**
             * Configuration options.
             *
             * @property {number} outputLength
             *   The desired number of bits in the output hash.
             *   Only values permitted are: 224, 256, 384, 512.
             *   Default: 512
             */
            cfg: Hasher.cfg.extend({
                outputLength: 512
            }),

            _doReset: function () {
                var state = this._state = []
                for (var i = 0; i < 25; i++) {
                    state[i] = new X64Word.init();
                }

                this.blockSize = (1600 - 2 * this.cfg.outputLength) / 32;
            },

            _doProcessBlock: function (M, offset) {
                // Shortcuts
                var state = this._state;
                var nBlockSizeLanes = this.blockSize / 2;

                // Absorb
                for (var i = 0; i < nBlockSizeLanes; i++) {
                    // Shortcuts
                    var M2i  = M[offset + 2 * i];
                    var M2i1 = M[offset + 2 * i + 1];

                    // Swap endian
                    M2i = (
                        (((M2i << 8)  | (M2i >>> 24)) & 0x00ff00ff) |
                        (((M2i << 24) | (M2i >>> 8))  & 0xff00ff00)
                    );
                    M2i1 = (
                        (((M2i1 << 8)  | (M2i1 >>> 24)) & 0x00ff00ff) |
                        (((M2i1 << 24) | (M2i1 >>> 8))  & 0xff00ff00)
                    );

                    // Absorb message into state
                    var lane = state[i];
                    lane.high ^= M2i1;
                    lane.low  ^= M2i;
                }

                // Rounds
                for (var round = 0; round < 24; round++) {
                    // Theta
                    for (var x = 0; x < 5; x++) {
                        // Mix column lanes
                        var tMsw = 0, tLsw = 0;
                        for (var y = 0; y < 5; y++) {
                            var lane = state[x + 5 * y];
                            tMsw ^= lane.high;
                            tLsw ^= lane.low;
                        }

                        // Temporary values
                        var Tx = T[x];
                        Tx.high = tMsw;
                        Tx.low  = tLsw;
                    }
                    for (var x = 0; x < 5; x++) {
                        // Shortcuts
                        var Tx4 = T[(x + 4) % 5];
                        var Tx1 = T[(x + 1) % 5];
                        var Tx1Msw = Tx1.high;
                        var Tx1Lsw = Tx1.low;

                        // Mix surrounding columns
                        var tMsw = Tx4.high ^ ((Tx1Msw << 1) | (Tx1Lsw >>> 31));
                        var tLsw = Tx4.low  ^ ((Tx1Lsw << 1) | (Tx1Msw >>> 31));
                        for (var y = 0; y < 5; y++) {
                            var lane = state[x + 5 * y];
                            lane.high ^= tMsw;
                            lane.low  ^= tLsw;
                        }
                    }

                    // Rho Pi
                    for (var laneIndex = 1; laneIndex < 25; laneIndex++) {
                        // Shortcuts
                        var lane = state[laneIndex];
                        var laneMsw = lane.high;
                        var laneLsw = lane.low;
                        var rhoOffset = RHO_OFFSETS[laneIndex];

                        // Rotate lanes
                        if (rhoOffset < 32) {
                            var tMsw = (laneMsw << rhoOffset) | (laneLsw >>> (32 - rhoOffset));
                            var tLsw = (laneLsw << rhoOffset) | (laneMsw >>> (32 - rhoOffset));
                        } else /* if (rhoOffset >= 32) */ {
                            var tMsw = (laneLsw << (rhoOffset - 32)) | (laneMsw >>> (64 - rhoOffset));
                            var tLsw = (laneMsw << (rhoOffset - 32)) | (laneLsw >>> (64 - rhoOffset));
                        }

                        // Transpose lanes
                        var TPiLane = T[PI_INDEXES[laneIndex]];
                        TPiLane.high = tMsw;
                        TPiLane.low  = tLsw;
                    }

                    // Rho pi at x = y = 0
                    var T0 = T[0];
                    var state0 = state[0];
                    T0.high = state0.high;
                    T0.low  = state0.low;

                    // Chi
                    for (var x = 0; x < 5; x++) {
                        for (var y = 0; y < 5; y++) {
                            // Shortcuts
                            var laneIndex = x + 5 * y;
                            var lane = state[laneIndex];
                            var TLane = T[laneIndex];
                            var Tx1Lane = T[((x + 1) % 5) + 5 * y];
                            var Tx2Lane = T[((x + 2) % 5) + 5 * y];

                            // Mix rows
                            lane.high = TLane.high ^ (~Tx1Lane.high & Tx2Lane.high);
                            lane.low  = TLane.low  ^ (~Tx1Lane.low  & Tx2Lane.low);
                        }
                    }

                    // Iota
                    var lane = state[0];
                    var roundConstant = ROUND_CONSTANTS[round];
                    lane.high ^= roundConstant.high;
                    lane.low  ^= roundConstant.low;;
                }
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;
                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;
                var blockSizeBits = this.blockSize * 32;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x1 << (24 - nBitsLeft % 32);
                dataWords[((Math.ceil((nBitsLeft + 1) / blockSizeBits) * blockSizeBits) >>> 5) - 1] |= 0x80;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Shortcuts
                var state = this._state;
                var outputLengthBytes = this.cfg.outputLength / 8;
                var outputLengthLanes = outputLengthBytes / 8;

                // Squeeze
                var hashWords = [];
                for (var i = 0; i < outputLengthLanes; i++) {
                    // Shortcuts
                    var lane = state[i];
                    var laneMsw = lane.high;
                    var laneLsw = lane.low;

                    // Swap endian
                    laneMsw = (
                        (((laneMsw << 8)  | (laneMsw >>> 24)) & 0x00ff00ff) |
                        (((laneMsw << 24) | (laneMsw >>> 8))  & 0xff00ff00)
                    );
                    laneLsw = (
                        (((laneLsw << 8)  | (laneLsw >>> 24)) & 0x00ff00ff) |
                        (((laneLsw << 24) | (laneLsw >>> 8))  & 0xff00ff00)
                    );

                    // Squeeze state to retrieve hash
                    hashWords.push(laneLsw);
                    hashWords.push(laneMsw);
                }

                // Return final computed hash
                return new WordArray.init(hashWords, outputLengthBytes);
            },

            clone: function () {
                var clone = Hasher.clone.call(this);

                var state = clone._state = this._state.slice(0);
                for (var i = 0; i < 25; i++) {
                    state[i] = state[i].clone();
                }

                return clone;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA3('message');
         *     var hash = CryptoJS.SHA3(wordArray);
         */
        C.SHA3 = Hasher._createHelper(SHA3);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA3(message, key);
         */
        C.HmacSHA3 = Hasher._createHmacHelper(SHA3);
    }(Math));


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Hasher = C_lib.Hasher;
        var C_x64 = C.x64;
        var X64Word = C_x64.Word;
        var X64WordArray = C_x64.WordArray;
        var C_algo = C.algo;

        function X64Word_create() {
            return X64Word.create.apply(X64Word, arguments);
        }

        // Constants
        var K = [
            X64Word_create(0x428a2f98, 0xd728ae22), X64Word_create(0x71374491, 0x23ef65cd),
            X64Word_create(0xb5c0fbcf, 0xec4d3b2f), X64Word_create(0xe9b5dba5, 0x8189dbbc),
            X64Word_create(0x3956c25b, 0xf348b538), X64Word_create(0x59f111f1, 0xb605d019),
            X64Word_create(0x923f82a4, 0xaf194f9b), X64Word_create(0xab1c5ed5, 0xda6d8118),
            X64Word_create(0xd807aa98, 0xa3030242), X64Word_create(0x12835b01, 0x45706fbe),
            X64Word_create(0x243185be, 0x4ee4b28c), X64Word_create(0x550c7dc3, 0xd5ffb4e2),
            X64Word_create(0x72be5d74, 0xf27b896f), X64Word_create(0x80deb1fe, 0x3b1696b1),
            X64Word_create(0x9bdc06a7, 0x25c71235), X64Word_create(0xc19bf174, 0xcf692694),
            X64Word_create(0xe49b69c1, 0x9ef14ad2), X64Word_create(0xefbe4786, 0x384f25e3),
            X64Word_create(0x0fc19dc6, 0x8b8cd5b5), X64Word_create(0x240ca1cc, 0x77ac9c65),
            X64Word_create(0x2de92c6f, 0x592b0275), X64Word_create(0x4a7484aa, 0x6ea6e483),
            X64Word_create(0x5cb0a9dc, 0xbd41fbd4), X64Word_create(0x76f988da, 0x831153b5),
            X64Word_create(0x983e5152, 0xee66dfab), X64Word_create(0xa831c66d, 0x2db43210),
            X64Word_create(0xb00327c8, 0x98fb213f), X64Word_create(0xbf597fc7, 0xbeef0ee4),
            X64Word_create(0xc6e00bf3, 0x3da88fc2), X64Word_create(0xd5a79147, 0x930aa725),
            X64Word_create(0x06ca6351, 0xe003826f), X64Word_create(0x14292967, 0x0a0e6e70),
            X64Word_create(0x27b70a85, 0x46d22ffc), X64Word_create(0x2e1b2138, 0x5c26c926),
            X64Word_create(0x4d2c6dfc, 0x5ac42aed), X64Word_create(0x53380d13, 0x9d95b3df),
            X64Word_create(0x650a7354, 0x8baf63de), X64Word_create(0x766a0abb, 0x3c77b2a8),
            X64Word_create(0x81c2c92e, 0x47edaee6), X64Word_create(0x92722c85, 0x1482353b),
            X64Word_create(0xa2bfe8a1, 0x4cf10364), X64Word_create(0xa81a664b, 0xbc423001),
            X64Word_create(0xc24b8b70, 0xd0f89791), X64Word_create(0xc76c51a3, 0x0654be30),
            X64Word_create(0xd192e819, 0xd6ef5218), X64Word_create(0xd6990624, 0x5565a910),
            X64Word_create(0xf40e3585, 0x5771202a), X64Word_create(0x106aa070, 0x32bbd1b8),
            X64Word_create(0x19a4c116, 0xb8d2d0c8), X64Word_create(0x1e376c08, 0x5141ab53),
            X64Word_create(0x2748774c, 0xdf8eeb99), X64Word_create(0x34b0bcb5, 0xe19b48a8),
            X64Word_create(0x391c0cb3, 0xc5c95a63), X64Word_create(0x4ed8aa4a, 0xe3418acb),
            X64Word_create(0x5b9cca4f, 0x7763e373), X64Word_create(0x682e6ff3, 0xd6b2b8a3),
            X64Word_create(0x748f82ee, 0x5defb2fc), X64Word_create(0x78a5636f, 0x43172f60),
            X64Word_create(0x84c87814, 0xa1f0ab72), X64Word_create(0x8cc70208, 0x1a6439ec),
            X64Word_create(0x90befffa, 0x23631e28), X64Word_create(0xa4506ceb, 0xde82bde9),
            X64Word_create(0xbef9a3f7, 0xb2c67915), X64Word_create(0xc67178f2, 0xe372532b),
            X64Word_create(0xca273ece, 0xea26619c), X64Word_create(0xd186b8c7, 0x21c0c207),
            X64Word_create(0xeada7dd6, 0xcde0eb1e), X64Word_create(0xf57d4f7f, 0xee6ed178),
            X64Word_create(0x06f067aa, 0x72176fba), X64Word_create(0x0a637dc5, 0xa2c898a6),
            X64Word_create(0x113f9804, 0xbef90dae), X64Word_create(0x1b710b35, 0x131c471b),
            X64Word_create(0x28db77f5, 0x23047d84), X64Word_create(0x32caab7b, 0x40c72493),
            X64Word_create(0x3c9ebe0a, 0x15c9bebc), X64Word_create(0x431d67c4, 0x9c100d4c),
            X64Word_create(0x4cc5d4be, 0xcb3e42b6), X64Word_create(0x597f299c, 0xfc657e2a),
            X64Word_create(0x5fcb6fab, 0x3ad6faec), X64Word_create(0x6c44198c, 0x4a475817)
        ];

        // Reusable objects
        var W = [];
        (function () {
            for (var i = 0; i < 80; i++) {
                W[i] = X64Word_create();
            }
        }());

        /**
         * SHA-512 hash algorithm.
         */
        var SHA512 = C_algo.SHA512 = Hasher.extend({
            _doReset: function () {
                this._hash = new X64WordArray.init([
                    new X64Word.init(0x6a09e667, 0xf3bcc908), new X64Word.init(0xbb67ae85, 0x84caa73b),
                    new X64Word.init(0x3c6ef372, 0xfe94f82b), new X64Word.init(0xa54ff53a, 0x5f1d36f1),
                    new X64Word.init(0x510e527f, 0xade682d1), new X64Word.init(0x9b05688c, 0x2b3e6c1f),
                    new X64Word.init(0x1f83d9ab, 0xfb41bd6b), new X64Word.init(0x5be0cd19, 0x137e2179)
                ]);
            },

            _doProcessBlock: function (M, offset) {
                // Shortcuts
                var H = this._hash.words;

                var H0 = H[0];
                var H1 = H[1];
                var H2 = H[2];
                var H3 = H[3];
                var H4 = H[4];
                var H5 = H[5];
                var H6 = H[6];
                var H7 = H[7];

                var H0h = H0.high;
                var H0l = H0.low;
                var H1h = H1.high;
                var H1l = H1.low;
                var H2h = H2.high;
                var H2l = H2.low;
                var H3h = H3.high;
                var H3l = H3.low;
                var H4h = H4.high;
                var H4l = H4.low;
                var H5h = H5.high;
                var H5l = H5.low;
                var H6h = H6.high;
                var H6l = H6.low;
                var H7h = H7.high;
                var H7l = H7.low;

                // Working variables
                var ah = H0h;
                var al = H0l;
                var bh = H1h;
                var bl = H1l;
                var ch = H2h;
                var cl = H2l;
                var dh = H3h;
                var dl = H3l;
                var eh = H4h;
                var el = H4l;
                var fh = H5h;
                var fl = H5l;
                var gh = H6h;
                var gl = H6l;
                var hh = H7h;
                var hl = H7l;

                // Rounds
                for (var i = 0; i < 80; i++) {
                    // Shortcut
                    var Wi = W[i];

                    // Extend message
                    if (i < 16) {
                        var Wih = Wi.high = M[offset + i * 2]     | 0;
                        var Wil = Wi.low  = M[offset + i * 2 + 1] | 0;
                    } else {
                        // Gamma0
                        var gamma0x  = W[i - 15];
                        var gamma0xh = gamma0x.high;
                        var gamma0xl = gamma0x.low;
                        var gamma0h  = ((gamma0xh >>> 1) | (gamma0xl << 31)) ^ ((gamma0xh >>> 8) | (gamma0xl << 24)) ^ (gamma0xh >>> 7);
                        var gamma0l  = ((gamma0xl >>> 1) | (gamma0xh << 31)) ^ ((gamma0xl >>> 8) | (gamma0xh << 24)) ^ ((gamma0xl >>> 7) | (gamma0xh << 25));

                        // Gamma1
                        var gamma1x  = W[i - 2];
                        var gamma1xh = gamma1x.high;
                        var gamma1xl = gamma1x.low;
                        var gamma1h  = ((gamma1xh >>> 19) | (gamma1xl << 13)) ^ ((gamma1xh << 3) | (gamma1xl >>> 29)) ^ (gamma1xh >>> 6);
                        var gamma1l  = ((gamma1xl >>> 19) | (gamma1xh << 13)) ^ ((gamma1xl << 3) | (gamma1xh >>> 29)) ^ ((gamma1xl >>> 6) | (gamma1xh << 26));

                        // W[i] = gamma0 + W[i - 7] + gamma1 + W[i - 16]
                        var Wi7  = W[i - 7];
                        var Wi7h = Wi7.high;
                        var Wi7l = Wi7.low;

                        var Wi16  = W[i - 16];
                        var Wi16h = Wi16.high;
                        var Wi16l = Wi16.low;

                        var Wil = gamma0l + Wi7l;
                        var Wih = gamma0h + Wi7h + ((Wil >>> 0) < (gamma0l >>> 0) ? 1 : 0);
                        var Wil = Wil + gamma1l;
                        var Wih = Wih + gamma1h + ((Wil >>> 0) < (gamma1l >>> 0) ? 1 : 0);
                        var Wil = Wil + Wi16l;
                        var Wih = Wih + Wi16h + ((Wil >>> 0) < (Wi16l >>> 0) ? 1 : 0);

                        Wi.high = Wih;
                        Wi.low  = Wil;
                    }

                    var chh  = (eh & fh) ^ (~eh & gh);
                    var chl  = (el & fl) ^ (~el & gl);
                    var majh = (ah & bh) ^ (ah & ch) ^ (bh & ch);
                    var majl = (al & bl) ^ (al & cl) ^ (bl & cl);

                    var sigma0h = ((ah >>> 28) | (al << 4))  ^ ((ah << 30)  | (al >>> 2)) ^ ((ah << 25) | (al >>> 7));
                    var sigma0l = ((al >>> 28) | (ah << 4))  ^ ((al << 30)  | (ah >>> 2)) ^ ((al << 25) | (ah >>> 7));
                    var sigma1h = ((eh >>> 14) | (el << 18)) ^ ((eh >>> 18) | (el << 14)) ^ ((eh << 23) | (el >>> 9));
                    var sigma1l = ((el >>> 14) | (eh << 18)) ^ ((el >>> 18) | (eh << 14)) ^ ((el << 23) | (eh >>> 9));

                    // t1 = h + sigma1 + ch + K[i] + W[i]
                    var Ki  = K[i];
                    var Kih = Ki.high;
                    var Kil = Ki.low;

                    var t1l = hl + sigma1l;
                    var t1h = hh + sigma1h + ((t1l >>> 0) < (hl >>> 0) ? 1 : 0);
                    var t1l = t1l + chl;
                    var t1h = t1h + chh + ((t1l >>> 0) < (chl >>> 0) ? 1 : 0);
                    var t1l = t1l + Kil;
                    var t1h = t1h + Kih + ((t1l >>> 0) < (Kil >>> 0) ? 1 : 0);
                    var t1l = t1l + Wil;
                    var t1h = t1h + Wih + ((t1l >>> 0) < (Wil >>> 0) ? 1 : 0);

                    // t2 = sigma0 + maj
                    var t2l = sigma0l + majl;
                    var t2h = sigma0h + majh + ((t2l >>> 0) < (sigma0l >>> 0) ? 1 : 0);

                    // Update working variables
                    hh = gh;
                    hl = gl;
                    gh = fh;
                    gl = fl;
                    fh = eh;
                    fl = el;
                    el = (dl + t1l) | 0;
                    eh = (dh + t1h + ((el >>> 0) < (dl >>> 0) ? 1 : 0)) | 0;
                    dh = ch;
                    dl = cl;
                    ch = bh;
                    cl = bl;
                    bh = ah;
                    bl = al;
                    al = (t1l + t2l) | 0;
                    ah = (t1h + t2h + ((al >>> 0) < (t1l >>> 0) ? 1 : 0)) | 0;
                }

                // Intermediate hash value
                H0l = H0.low  = (H0l + al);
                H0.high = (H0h + ah + ((H0l >>> 0) < (al >>> 0) ? 1 : 0));
                H1l = H1.low  = (H1l + bl);
                H1.high = (H1h + bh + ((H1l >>> 0) < (bl >>> 0) ? 1 : 0));
                H2l = H2.low  = (H2l + cl);
                H2.high = (H2h + ch + ((H2l >>> 0) < (cl >>> 0) ? 1 : 0));
                H3l = H3.low  = (H3l + dl);
                H3.high = (H3h + dh + ((H3l >>> 0) < (dl >>> 0) ? 1 : 0));
                H4l = H4.low  = (H4l + el);
                H4.high = (H4h + eh + ((H4l >>> 0) < (el >>> 0) ? 1 : 0));
                H5l = H5.low  = (H5l + fl);
                H5.high = (H5h + fh + ((H5l >>> 0) < (fl >>> 0) ? 1 : 0));
                H6l = H6.low  = (H6l + gl);
                H6.high = (H6h + gh + ((H6l >>> 0) < (gl >>> 0) ? 1 : 0));
                H7l = H7.low  = (H7l + hl);
                H7.high = (H7h + hh + ((H7l >>> 0) < (hl >>> 0) ? 1 : 0));
            },

            _doFinalize: function () {
                // Shortcuts
                var data = this._data;
                var dataWords = data.words;

                var nBitsTotal = this._nDataBytes * 8;
                var nBitsLeft = data.sigBytes * 8;

                // Add padding
                dataWords[nBitsLeft >>> 5] |= 0x80 << (24 - nBitsLeft % 32);
                dataWords[(((nBitsLeft + 128) >>> 10) << 5) + 30] = Math.floor(nBitsTotal / 0x100000000);
                dataWords[(((nBitsLeft + 128) >>> 10) << 5) + 31] = nBitsTotal;
                data.sigBytes = dataWords.length * 4;

                // Hash final blocks
                this._process();

                // Convert hash to 32-bit word array before returning
                var hash = this._hash.toX32();

                // Return final computed hash
                return hash;
            },

            clone: function () {
                var clone = Hasher.clone.call(this);
                clone._hash = this._hash.clone();

                return clone;
            },

            blockSize: 1024/32
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA512('message');
         *     var hash = CryptoJS.SHA512(wordArray);
         */
        C.SHA512 = Hasher._createHelper(SHA512);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA512(message, key);
         */
        C.HmacSHA512 = Hasher._createHmacHelper(SHA512);
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_x64 = C.x64;
        var X64Word = C_x64.Word;
        var X64WordArray = C_x64.WordArray;
        var C_algo = C.algo;
        var SHA512 = C_algo.SHA512;

        /**
         * SHA-384 hash algorithm.
         */
        var SHA384 = C_algo.SHA384 = SHA512.extend({
            _doReset: function () {
                this._hash = new X64WordArray.init([
                    new X64Word.init(0xcbbb9d5d, 0xc1059ed8), new X64Word.init(0x629a292a, 0x367cd507),
                    new X64Word.init(0x9159015a, 0x3070dd17), new X64Word.init(0x152fecd8, 0xf70e5939),
                    new X64Word.init(0x67332667, 0xffc00b31), new X64Word.init(0x8eb44a87, 0x68581511),
                    new X64Word.init(0xdb0c2e0d, 0x64f98fa7), new X64Word.init(0x47b5481d, 0xbefa4fa4)
                ]);
            },

            _doFinalize: function () {
                var hash = SHA512._doFinalize.call(this);

                hash.sigBytes -= 16;

                return hash;
            }
        });

        /**
         * Shortcut function to the hasher's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         *
         * @return {WordArray} The hash.
         *
         * @static
         *
         * @example
         *
         *     var hash = CryptoJS.SHA384('message');
         *     var hash = CryptoJS.SHA384(wordArray);
         */
        C.SHA384 = SHA512._createHelper(SHA384);

        /**
         * Shortcut function to the HMAC's object interface.
         *
         * @param {WordArray|string} message The message to hash.
         * @param {WordArray|string} key The secret key.
         *
         * @return {WordArray} The HMAC.
         *
         * @static
         *
         * @example
         *
         *     var hmac = CryptoJS.HmacSHA384(message, key);
         */
        C.HmacSHA384 = SHA512._createHmacHelper(SHA384);
    }());


    /**
     * Cipher core components.
     */
    CryptoJS.lib.Cipher || (function (undefined) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var Base = C_lib.Base;
        var WordArray = C_lib.WordArray;
        var BufferedBlockAlgorithm = C_lib.BufferedBlockAlgorithm;
        var C_enc = C.enc;
        var Utf8 = C_enc.Utf8;
        var Base64 = C_enc.Base64;
        var C_algo = C.algo;
        var EvpKDF = C_algo.EvpKDF;

        /**
         * Abstract base cipher template.
         *
         * @property {number} keySize This cipher's key size. Default: 4 (128 bits)
         * @property {number} ivSize This cipher's IV size. Default: 4 (128 bits)
         * @property {number} _ENC_XFORM_MODE A constant representing encryption mode.
         * @property {number} _DEC_XFORM_MODE A constant representing decryption mode.
         */
        var Cipher = C_lib.Cipher = BufferedBlockAlgorithm.extend({
            /**
             * Configuration options.
             *
             * @property {WordArray} iv The IV to use for this operation.
             */
            cfg: Base.extend(),

            /**
             * Creates this cipher in encryption mode.
             *
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {Cipher} A cipher instance.
             *
             * @static
             *
             * @example
             *
             *     var cipher = CryptoJS.algo.AES.createEncryptor(keyWordArray, { iv: ivWordArray });
             */
            createEncryptor: function (key, cfg) {
                return this.create(this._ENC_XFORM_MODE, key, cfg);
            },

            /**
             * Creates this cipher in decryption mode.
             *
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {Cipher} A cipher instance.
             *
             * @static
             *
             * @example
             *
             *     var cipher = CryptoJS.algo.AES.createDecryptor(keyWordArray, { iv: ivWordArray });
             */
            createDecryptor: function (key, cfg) {
                return this.create(this._DEC_XFORM_MODE, key, cfg);
            },

            /**
             * Initializes a newly created cipher.
             *
             * @param {number} xformMode Either the encryption or decryption transormation mode constant.
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @example
             *
             *     var cipher = CryptoJS.algo.AES.create(CryptoJS.algo.AES._ENC_XFORM_MODE, keyWordArray, { iv: ivWordArray });
             */
            init: function (xformMode, key, cfg) {
                // Apply config defaults
                this.cfg = this.cfg.extend(cfg);

                // Store transform mode and key
                this._xformMode = xformMode;
                this._key = key;

                // Set initial values
                this.reset();
            },

            /**
             * Resets this cipher to its initial state.
             *
             * @example
             *
             *     cipher.reset();
             */
            reset: function () {
                // Reset data buffer
                BufferedBlockAlgorithm.reset.call(this);

                // Perform concrete-cipher logic
                this._doReset();
            },

            /**
             * Adds data to be encrypted or decrypted.
             *
             * @param {WordArray|string} dataUpdate The data to encrypt or decrypt.
             *
             * @return {WordArray} The data after processing.
             *
             * @example
             *
             *     var encrypted = cipher.process('data');
             *     var encrypted = cipher.process(wordArray);
             */
            process: function (dataUpdate) {
                // Append
                this._append(dataUpdate);

                // Process available blocks
                return this._process();
            },

            /**
             * Finalizes the encryption or decryption process.
             * Note that the finalize operation is effectively a destructive, read-once operation.
             *
             * @param {WordArray|string} dataUpdate The final data to encrypt or decrypt.
             *
             * @return {WordArray} The data after final processing.
             *
             * @example
             *
             *     var encrypted = cipher.finalize();
             *     var encrypted = cipher.finalize('data');
             *     var encrypted = cipher.finalize(wordArray);
             */
            finalize: function (dataUpdate) {
                // Final data update
                if (dataUpdate) {
                    this._append(dataUpdate);
                }

                // Perform concrete-cipher logic
                var finalProcessedData = this._doFinalize();

                return finalProcessedData;
            },

            keySize: 128/32,

            ivSize: 128/32,

            _ENC_XFORM_MODE: 1,

            _DEC_XFORM_MODE: 2,

            /**
             * Creates shortcut functions to a cipher's object interface.
             *
             * @param {Cipher} cipher The cipher to create a helper for.
             *
             * @return {Object} An object with encrypt and decrypt shortcut functions.
             *
             * @static
             *
             * @example
             *
             *     var AES = CryptoJS.lib.Cipher._createHelper(CryptoJS.algo.AES);
             */
            _createHelper: (function () {
                function selectCipherStrategy(key) {
                    if (typeof key == 'string') {
                        return PasswordBasedCipher;
                    } else {
                        return SerializableCipher;
                    }
                }

                return function (cipher) {
                    return {
                        encrypt: function (message, key, cfg) {
                            return selectCipherStrategy(key).encrypt(cipher, message, key, cfg);
                        },

                        decrypt: function (ciphertext, key, cfg) {
                            return selectCipherStrategy(key).decrypt(cipher, ciphertext, key, cfg);
                        }
                    };
                };
            }())
        });

        /**
         * Abstract base stream cipher template.
         *
         * @property {number} blockSize The number of 32-bit words this cipher operates on. Default: 1 (32 bits)
         */
        var StreamCipher = C_lib.StreamCipher = Cipher.extend({
            _doFinalize: function () {
                // Process partial blocks
                var finalProcessedBlocks = this._process(!!'flush');

                return finalProcessedBlocks;
            },

            blockSize: 1
        });

        /**
         * Mode namespace.
         */
        var C_mode = C.mode = {};

        /**
         * Abstract base block cipher mode template.
         */
        var BlockCipherMode = C_lib.BlockCipherMode = Base.extend({
            /**
             * Creates this mode for encryption.
             *
             * @param {Cipher} cipher A block cipher instance.
             * @param {Array} iv The IV words.
             *
             * @static
             *
             * @example
             *
             *     var mode = CryptoJS.mode.CBC.createEncryptor(cipher, iv.words);
             */
            createEncryptor: function (cipher, iv) {
                return this.Encryptor.create(cipher, iv);
            },

            /**
             * Creates this mode for decryption.
             *
             * @param {Cipher} cipher A block cipher instance.
             * @param {Array} iv The IV words.
             *
             * @static
             *
             * @example
             *
             *     var mode = CryptoJS.mode.CBC.createDecryptor(cipher, iv.words);
             */
            createDecryptor: function (cipher, iv) {
                return this.Decryptor.create(cipher, iv);
            },

            /**
             * Initializes a newly created mode.
             *
             * @param {Cipher} cipher A block cipher instance.
             * @param {Array} iv The IV words.
             *
             * @example
             *
             *     var mode = CryptoJS.mode.CBC.Encryptor.create(cipher, iv.words);
             */
            init: function (cipher, iv) {
                this._cipher = cipher;
                this._iv = iv;
            }
        });

        /**
         * Cipher Block Chaining mode.
         */
        var CBC = C_mode.CBC = (function () {
            /**
             * Abstract base CBC mode.
             */
            var CBC = BlockCipherMode.extend();

            /**
             * CBC encryptor.
             */
            CBC.Encryptor = CBC.extend({
                /**
                 * Processes the data block at offset.
                 *
                 * @param {Array} words The data words to operate on.
                 * @param {number} offset The offset where the block starts.
                 *
                 * @example
                 *
                 *     mode.processBlock(data.words, offset);
                 */
                processBlock: function (words, offset) {
                    // Shortcuts
                    var cipher = this._cipher;
                    var blockSize = cipher.blockSize;

                    // XOR and encrypt
                    xorBlock.call(this, words, offset, blockSize);
                    cipher.encryptBlock(words, offset);

                    // Remember this block to use with next block
                    this._prevBlock = words.slice(offset, offset + blockSize);
                }
            });

            /**
             * CBC decryptor.
             */
            CBC.Decryptor = CBC.extend({
                /**
                 * Processes the data block at offset.
                 *
                 * @param {Array} words The data words to operate on.
                 * @param {number} offset The offset where the block starts.
                 *
                 * @example
                 *
                 *     mode.processBlock(data.words, offset);
                 */
                processBlock: function (words, offset) {
                    // Shortcuts
                    var cipher = this._cipher;
                    var blockSize = cipher.blockSize;

                    // Remember this block to use with next block
                    var thisBlock = words.slice(offset, offset + blockSize);

                    // Decrypt and XOR
                    cipher.decryptBlock(words, offset);
                    xorBlock.call(this, words, offset, blockSize);

                    // This block becomes the previous block
                    this._prevBlock = thisBlock;
                }
            });

            function xorBlock(words, offset, blockSize) {
                // Shortcut
                var iv = this._iv;

                // Choose mixing block
                if (iv) {
                    var block = iv;

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                } else {
                    var block = this._prevBlock;
                }

                // XOR blocks
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= block[i];
                }
            }

            return CBC;
        }());

        /**
         * Padding namespace.
         */
        var C_pad = C.pad = {};

        /**
         * PKCS #5/7 padding strategy.
         */
        var Pkcs7 = C_pad.Pkcs7 = {
            /**
             * Pads data using the algorithm defined in PKCS #5/7.
             *
             * @param {WordArray} data The data to pad.
             * @param {number} blockSize The multiple that the data should be padded to.
             *
             * @static
             *
             * @example
             *
             *     CryptoJS.pad.Pkcs7.pad(wordArray, 4);
             */
            pad: function (data, blockSize) {
                // Shortcut
                var blockSizeBytes = blockSize * 4;

                // Count padding bytes
                var nPaddingBytes = blockSizeBytes - data.sigBytes % blockSizeBytes;

                // Create padding word
                var paddingWord = (nPaddingBytes << 24) | (nPaddingBytes << 16) | (nPaddingBytes << 8) | nPaddingBytes;

                // Create padding
                var paddingWords = [];
                for (var i = 0; i < nPaddingBytes; i += 4) {
                    paddingWords.push(paddingWord);
                }
                var padding = WordArray.create(paddingWords, nPaddingBytes);

                // Add padding
                data.concat(padding);
            },

            /**
             * Unpads data that had been padded using the algorithm defined in PKCS #5/7.
             *
             * @param {WordArray} data The data to unpad.
             *
             * @static
             *
             * @example
             *
             *     CryptoJS.pad.Pkcs7.unpad(wordArray);
             */
            unpad: function (data) {
                // Get number of padding bytes from last byte
                var nPaddingBytes = data.words[(data.sigBytes - 1) >>> 2] & 0xff;

                // Remove padding
                data.sigBytes -= nPaddingBytes;
            }
        };

        /**
         * Abstract base block cipher template.
         *
         * @property {number} blockSize The number of 32-bit words this cipher operates on. Default: 4 (128 bits)
         */
        var BlockCipher = C_lib.BlockCipher = Cipher.extend({
            /**
             * Configuration options.
             *
             * @property {Mode} mode The block mode to use. Default: CBC
             * @property {Padding} padding The padding strategy to use. Default: Pkcs7
             */
            cfg: Cipher.cfg.extend({
                mode: CBC,
                padding: Pkcs7
            }),

            reset: function () {
                // Reset cipher
                Cipher.reset.call(this);

                // Shortcuts
                var cfg = this.cfg;
                var iv = cfg.iv;
                var mode = cfg.mode;

                // Reset block mode
                if (this._xformMode == this._ENC_XFORM_MODE) {
                    var modeCreator = mode.createEncryptor;
                } else /* if (this._xformMode == this._DEC_XFORM_MODE) */ {
                    var modeCreator = mode.createDecryptor;
                    // Keep at least one block in the buffer for unpadding
                    this._minBufferSize = 1;
                }

                if (this._mode && this._mode.__creator == modeCreator) {
                    this._mode.init(this, iv && iv.words);
                } else {
                    this._mode = modeCreator.call(mode, this, iv && iv.words);
                    this._mode.__creator = modeCreator;
                }
            },

            _doProcessBlock: function (words, offset) {
                this._mode.processBlock(words, offset);
            },

            _doFinalize: function () {
                // Shortcut
                var padding = this.cfg.padding;

                // Finalize
                if (this._xformMode == this._ENC_XFORM_MODE) {
                    // Pad data
                    padding.pad(this._data, this.blockSize);

                    // Process final blocks
                    var finalProcessedBlocks = this._process(!!'flush');
                } else /* if (this._xformMode == this._DEC_XFORM_MODE) */ {
                    // Process final blocks
                    var finalProcessedBlocks = this._process(!!'flush');

                    // Unpad data
                    padding.unpad(finalProcessedBlocks);
                }

                return finalProcessedBlocks;
            },

            blockSize: 128/32
        });

        /**
         * A collection of cipher parameters.
         *
         * @property {WordArray} ciphertext The raw ciphertext.
         * @property {WordArray} key The key to this ciphertext.
         * @property {WordArray} iv The IV used in the ciphering operation.
         * @property {WordArray} salt The salt used with a key derivation function.
         * @property {Cipher} algorithm The cipher algorithm.
         * @property {Mode} mode The block mode used in the ciphering operation.
         * @property {Padding} padding The padding scheme used in the ciphering operation.
         * @property {number} blockSize The block size of the cipher.
         * @property {Format} formatter The default formatting strategy to convert this cipher params object to a string.
         */
        var CipherParams = C_lib.CipherParams = Base.extend({
            /**
             * Initializes a newly created cipher params object.
             *
             * @param {Object} cipherParams An object with any of the possible cipher parameters.
             *
             * @example
             *
             *     var cipherParams = CryptoJS.lib.CipherParams.create({
	         *         ciphertext: ciphertextWordArray,
	         *         key: keyWordArray,
	         *         iv: ivWordArray,
	         *         salt: saltWordArray,
	         *         algorithm: CryptoJS.algo.AES,
	         *         mode: CryptoJS.mode.CBC,
	         *         padding: CryptoJS.pad.PKCS7,
	         *         blockSize: 4,
	         *         formatter: CryptoJS.format.OpenSSL
	         *     });
             */
            init: function (cipherParams) {
                this.mixIn(cipherParams);
            },

            /**
             * Converts this cipher params object to a string.
             *
             * @param {Format} formatter (Optional) The formatting strategy to use.
             *
             * @return {string} The stringified cipher params.
             *
             * @throws Error If neither the formatter nor the default formatter is set.
             *
             * @example
             *
             *     var string = cipherParams + '';
             *     var string = cipherParams.toString();
             *     var string = cipherParams.toString(CryptoJS.format.OpenSSL);
             */
            toString: function (formatter) {
                return (formatter || this.formatter).stringify(this);
            }
        });

        /**
         * Format namespace.
         */
        var C_format = C.format = {};

        /**
         * OpenSSL formatting strategy.
         */
        var OpenSSLFormatter = C_format.OpenSSL = {
            /**
             * Converts a cipher params object to an OpenSSL-compatible string.
             *
             * @param {CipherParams} cipherParams The cipher params object.
             *
             * @return {string} The OpenSSL-compatible string.
             *
             * @static
             *
             * @example
             *
             *     var openSSLString = CryptoJS.format.OpenSSL.stringify(cipherParams);
             */
            stringify: function (cipherParams) {
                // Shortcuts
                var ciphertext = cipherParams.ciphertext;
                var salt = cipherParams.salt;

                // Format
                if (salt) {
                    var wordArray = WordArray.create([0x53616c74, 0x65645f5f]).concat(salt).concat(ciphertext);
                } else {
                    var wordArray = ciphertext;
                }

                return wordArray.toString(Base64);
            },

            /**
             * Converts an OpenSSL-compatible string to a cipher params object.
             *
             * @param {string} openSSLStr The OpenSSL-compatible string.
             *
             * @return {CipherParams} The cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var cipherParams = CryptoJS.format.OpenSSL.parse(openSSLString);
             */
            parse: function (openSSLStr) {
                // Parse base64
                var ciphertext = Base64.parse(openSSLStr);

                // Shortcut
                var ciphertextWords = ciphertext.words;

                // Test for salt
                if (ciphertextWords[0] == 0x53616c74 && ciphertextWords[1] == 0x65645f5f) {
                    // Extract salt
                    var salt = WordArray.create(ciphertextWords.slice(2, 4));

                    // Remove salt from ciphertext
                    ciphertextWords.splice(0, 4);
                    ciphertext.sigBytes -= 16;
                }

                return CipherParams.create({ ciphertext: ciphertext, salt: salt });
            }
        };

        /**
         * A cipher wrapper that returns ciphertext as a serializable cipher params object.
         */
        var SerializableCipher = C_lib.SerializableCipher = Base.extend({
            /**
             * Configuration options.
             *
             * @property {Formatter} format The formatting strategy to convert cipher param objects to and from a string. Default: OpenSSL
             */
            cfg: Base.extend({
                format: OpenSSLFormatter
            }),

            /**
             * Encrypts a message.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {WordArray|string} message The message to encrypt.
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {CipherParams} A cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher.encrypt(CryptoJS.algo.AES, message, key);
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher.encrypt(CryptoJS.algo.AES, message, key, { iv: iv });
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher.encrypt(CryptoJS.algo.AES, message, key, { iv: iv, format: CryptoJS.format.OpenSSL });
             */
            encrypt: function (cipher, message, key, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Encrypt
                var encryptor = cipher.createEncryptor(key, cfg);
                var ciphertext = encryptor.finalize(message);

                // Shortcut
                var cipherCfg = encryptor.cfg;

                // Create and return serializable cipher params
                return CipherParams.create({
                    ciphertext: ciphertext,
                    key: key,
                    iv: cipherCfg.iv,
                    algorithm: cipher,
                    mode: cipherCfg.mode,
                    padding: cipherCfg.padding,
                    blockSize: cipher.blockSize,
                    formatter: cfg.format
                });
            },

            /**
             * Decrypts serialized ciphertext.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {CipherParams|string} ciphertext The ciphertext to decrypt.
             * @param {WordArray} key The key.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {WordArray} The plaintext.
             *
             * @static
             *
             * @example
             *
             *     var plaintext = CryptoJS.lib.SerializableCipher.decrypt(CryptoJS.algo.AES, formattedCiphertext, key, { iv: iv, format: CryptoJS.format.OpenSSL });
             *     var plaintext = CryptoJS.lib.SerializableCipher.decrypt(CryptoJS.algo.AES, ciphertextParams, key, { iv: iv, format: CryptoJS.format.OpenSSL });
             */
            decrypt: function (cipher, ciphertext, key, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Convert string to CipherParams
                ciphertext = this._parse(ciphertext, cfg.format);

                // Decrypt
                var plaintext = cipher.createDecryptor(key, cfg).finalize(ciphertext.ciphertext);

                return plaintext;
            },

            /**
             * Converts serialized ciphertext to CipherParams,
             * else assumed CipherParams already and returns ciphertext unchanged.
             *
             * @param {CipherParams|string} ciphertext The ciphertext.
             * @param {Formatter} format The formatting strategy to use to parse serialized ciphertext.
             *
             * @return {CipherParams} The unserialized ciphertext.
             *
             * @static
             *
             * @example
             *
             *     var ciphertextParams = CryptoJS.lib.SerializableCipher._parse(ciphertextStringOrParams, format);
             */
            _parse: function (ciphertext, format) {
                if (typeof ciphertext == 'string') {
                    return format.parse(ciphertext, this);
                } else {
                    return ciphertext;
                }
            }
        });

        /**
         * Key derivation function namespace.
         */
        var C_kdf = C.kdf = {};

        /**
         * OpenSSL key derivation function.
         */
        var OpenSSLKdf = C_kdf.OpenSSL = {
            /**
             * Derives a key and IV from a password.
             *
             * @param {string} password The password to derive from.
             * @param {number} keySize The size in words of the key to generate.
             * @param {number} ivSize The size in words of the IV to generate.
             * @param {WordArray|string} salt (Optional) A 64-bit salt to use. If omitted, a salt will be generated randomly.
             *
             * @return {CipherParams} A cipher params object with the key, IV, and salt.
             *
             * @static
             *
             * @example
             *
             *     var derivedParams = CryptoJS.kdf.OpenSSL.execute('Password', 256/32, 128/32);
             *     var derivedParams = CryptoJS.kdf.OpenSSL.execute('Password', 256/32, 128/32, 'saltsalt');
             */
            execute: function (password, keySize, ivSize, salt) {
                // Generate random salt
                if (!salt) {
                    salt = WordArray.random(64/8);
                }

                // Derive key and IV
                var key = EvpKDF.create({ keySize: keySize + ivSize }).compute(password, salt);

                // Separate key and IV
                var iv = WordArray.create(key.words.slice(keySize), ivSize * 4);
                key.sigBytes = keySize * 4;

                // Return params
                return CipherParams.create({ key: key, iv: iv, salt: salt });
            }
        };

        /**
         * A serializable cipher wrapper that derives the key from a password,
         * and returns ciphertext as a serializable cipher params object.
         */
        var PasswordBasedCipher = C_lib.PasswordBasedCipher = SerializableCipher.extend({
            /**
             * Configuration options.
             *
             * @property {KDF} kdf The key derivation function to use to generate a key and IV from a password. Default: OpenSSL
             */
            cfg: SerializableCipher.cfg.extend({
                kdf: OpenSSLKdf
            }),

            /**
             * Encrypts a message using a password.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {WordArray|string} message The message to encrypt.
             * @param {string} password The password.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {CipherParams} A cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var ciphertextParams = CryptoJS.lib.PasswordBasedCipher.encrypt(CryptoJS.algo.AES, message, 'password');
             *     var ciphertextParams = CryptoJS.lib.PasswordBasedCipher.encrypt(CryptoJS.algo.AES, message, 'password', { format: CryptoJS.format.OpenSSL });
             */
            encrypt: function (cipher, message, password, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Derive key and other params
                var derivedParams = cfg.kdf.execute(password, cipher.keySize, cipher.ivSize);

                // Add IV to config
                cfg.iv = derivedParams.iv;

                // Encrypt
                var ciphertext = SerializableCipher.encrypt.call(this, cipher, message, derivedParams.key, cfg);

                // Mix in derived params
                ciphertext.mixIn(derivedParams);

                return ciphertext;
            },

            /**
             * Decrypts serialized ciphertext using a password.
             *
             * @param {Cipher} cipher The cipher algorithm to use.
             * @param {CipherParams|string} ciphertext The ciphertext to decrypt.
             * @param {string} password The password.
             * @param {Object} cfg (Optional) The configuration options to use for this operation.
             *
             * @return {WordArray} The plaintext.
             *
             * @static
             *
             * @example
             *
             *     var plaintext = CryptoJS.lib.PasswordBasedCipher.decrypt(CryptoJS.algo.AES, formattedCiphertext, 'password', { format: CryptoJS.format.OpenSSL });
             *     var plaintext = CryptoJS.lib.PasswordBasedCipher.decrypt(CryptoJS.algo.AES, ciphertextParams, 'password', { format: CryptoJS.format.OpenSSL });
             */
            decrypt: function (cipher, ciphertext, password, cfg) {
                // Apply config defaults
                cfg = this.cfg.extend(cfg);

                // Convert string to CipherParams
                ciphertext = this._parse(ciphertext, cfg.format);

                // Derive key and other params
                var derivedParams = cfg.kdf.execute(password, cipher.keySize, cipher.ivSize, ciphertext.salt);

                // Add IV to config
                cfg.iv = derivedParams.iv;

                // Decrypt
                var plaintext = SerializableCipher.decrypt.call(this, cipher, ciphertext, derivedParams.key, cfg);

                return plaintext;
            }
        });
    }());


    /**
     * Cipher Feedback block mode.
     */
    CryptoJS.mode.CFB = (function () {
        var CFB = CryptoJS.lib.BlockCipherMode.extend();

        CFB.Encryptor = CFB.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher;
                var blockSize = cipher.blockSize;

                generateKeystreamAndEncrypt.call(this, words, offset, blockSize, cipher);

                // Remember this block to use with next block
                this._prevBlock = words.slice(offset, offset + blockSize);
            }
        });

        CFB.Decryptor = CFB.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher;
                var blockSize = cipher.blockSize;

                // Remember this block to use with next block
                var thisBlock = words.slice(offset, offset + blockSize);

                generateKeystreamAndEncrypt.call(this, words, offset, blockSize, cipher);

                // This block becomes the previous block
                this._prevBlock = thisBlock;
            }
        });

        function generateKeystreamAndEncrypt(words, offset, blockSize, cipher) {
            // Shortcut
            var iv = this._iv;

            // Generate keystream
            if (iv) {
                var keystream = iv.slice(0);

                // Remove IV for subsequent blocks
                this._iv = undefined;
            } else {
                var keystream = this._prevBlock;
            }
            cipher.encryptBlock(keystream, 0);

            // Encrypt
            for (var i = 0; i < blockSize; i++) {
                words[offset + i] ^= keystream[i];
            }
        }

        return CFB;
    }());


    /**
     * Electronic Codebook block mode.
     */
    CryptoJS.mode.ECB = (function () {
        var ECB = CryptoJS.lib.BlockCipherMode.extend();

        ECB.Encryptor = ECB.extend({
            processBlock: function (words, offset) {
                this._cipher.encryptBlock(words, offset);
            }
        });

        ECB.Decryptor = ECB.extend({
            processBlock: function (words, offset) {
                this._cipher.decryptBlock(words, offset);
            }
        });

        return ECB;
    }());


    /**
     * ANSI X.923 padding strategy.
     */
    CryptoJS.pad.AnsiX923 = {
        pad: function (data, blockSize) {
            // Shortcuts
            var dataSigBytes = data.sigBytes;
            var blockSizeBytes = blockSize * 4;

            // Count padding bytes
            var nPaddingBytes = blockSizeBytes - dataSigBytes % blockSizeBytes;

            // Compute last byte position
            var lastBytePos = dataSigBytes + nPaddingBytes - 1;

            // Pad
            data.clamp();
            data.words[lastBytePos >>> 2] |= nPaddingBytes << (24 - (lastBytePos % 4) * 8);
            data.sigBytes += nPaddingBytes;
        },

        unpad: function (data) {
            // Get number of padding bytes from last byte
            var nPaddingBytes = data.words[(data.sigBytes - 1) >>> 2] & 0xff;

            // Remove padding
            data.sigBytes -= nPaddingBytes;
        }
    };


    /**
     * ISO 10126 padding strategy.
     */
    CryptoJS.pad.Iso10126 = {
        pad: function (data, blockSize) {
            // Shortcut
            var blockSizeBytes = blockSize * 4;

            // Count padding bytes
            var nPaddingBytes = blockSizeBytes - data.sigBytes % blockSizeBytes;

            // Pad
            data.concat(CryptoJS.lib.WordArray.random(nPaddingBytes - 1)).
            concat(CryptoJS.lib.WordArray.create([nPaddingBytes << 24], 1));
        },

        unpad: function (data) {
            // Get number of padding bytes from last byte
            var nPaddingBytes = data.words[(data.sigBytes - 1) >>> 2] & 0xff;

            // Remove padding
            data.sigBytes -= nPaddingBytes;
        }
    };


    /**
     * ISO/IEC 9797-1 Padding Method 2.
     */
    CryptoJS.pad.Iso97971 = {
        pad: function (data, blockSize) {
            // Add 0x80 byte
            data.concat(CryptoJS.lib.WordArray.create([0x80000000], 1));

            // Zero pad the rest
            CryptoJS.pad.ZeroPadding.pad(data, blockSize);
        },

        unpad: function (data) {
            // Remove zero padding
            CryptoJS.pad.ZeroPadding.unpad(data);

            // Remove one more byte -- the 0x80 byte
            data.sigBytes--;
        }
    };


    /**
     * Output Feedback block mode.
     */
    CryptoJS.mode.OFB = (function () {
        var OFB = CryptoJS.lib.BlockCipherMode.extend();

        var Encryptor = OFB.Encryptor = OFB.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher
                var blockSize = cipher.blockSize;
                var iv = this._iv;
                var keystream = this._keystream;

                // Generate keystream
                if (iv) {
                    keystream = this._keystream = iv.slice(0);

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                }
                cipher.encryptBlock(keystream, 0);

                // Encrypt
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= keystream[i];
                }
            }
        });

        OFB.Decryptor = Encryptor;

        return OFB;
    }());


    /**
     * A noop padding strategy.
     */
    CryptoJS.pad.NoPadding = {
        pad: function () {
        },

        unpad: function () {
        }
    };


    (function (undefined) {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var CipherParams = C_lib.CipherParams;
        var C_enc = C.enc;
        var Hex = C_enc.Hex;
        var C_format = C.format;

        var HexFormatter = C_format.Hex = {
            /**
             * Converts the ciphertext of a cipher params object to a hexadecimally encoded string.
             *
             * @param {CipherParams} cipherParams The cipher params object.
             *
             * @return {string} The hexadecimally encoded string.
             *
             * @static
             *
             * @example
             *
             *     var hexString = CryptoJS.format.Hex.stringify(cipherParams);
             */
            stringify: function (cipherParams) {
                return cipherParams.ciphertext.toString(Hex);
            },

            /**
             * Converts a hexadecimally encoded ciphertext string to a cipher params object.
             *
             * @param {string} input The hexadecimally encoded string.
             *
             * @return {CipherParams} The cipher params object.
             *
             * @static
             *
             * @example
             *
             *     var cipherParams = CryptoJS.format.Hex.parse(hexString);
             */
            parse: function (input) {
                var ciphertext = Hex.parse(input);
                return CipherParams.create({ ciphertext: ciphertext });
            }
        };
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var BlockCipher = C_lib.BlockCipher;
        var C_algo = C.algo;

        // Lookup tables
        var SBOX = [];
        var INV_SBOX = [];
        var SUB_MIX_0 = [];
        var SUB_MIX_1 = [];
        var SUB_MIX_2 = [];
        var SUB_MIX_3 = [];
        var INV_SUB_MIX_0 = [];
        var INV_SUB_MIX_1 = [];
        var INV_SUB_MIX_2 = [];
        var INV_SUB_MIX_3 = [];

        // Compute lookup tables
        (function () {
            // Compute double table
            var d = [];
            for (var i = 0; i < 256; i++) {
                if (i < 128) {
                    d[i] = i << 1;
                } else {
                    d[i] = (i << 1) ^ 0x11b;
                }
            }

            // Walk GF(2^8)
            var x = 0;
            var xi = 0;
            for (var i = 0; i < 256; i++) {
                // Compute sbox
                var sx = xi ^ (xi << 1) ^ (xi << 2) ^ (xi << 3) ^ (xi << 4);
                sx = (sx >>> 8) ^ (sx & 0xff) ^ 0x63;
                SBOX[x] = sx;
                INV_SBOX[sx] = x;

                // Compute multiplication
                var x2 = d[x];
                var x4 = d[x2];
                var x8 = d[x4];

                // Compute sub bytes, mix columns tables
                var t = (d[sx] * 0x101) ^ (sx * 0x1010100);
                SUB_MIX_0[x] = (t << 24) | (t >>> 8);
                SUB_MIX_1[x] = (t << 16) | (t >>> 16);
                SUB_MIX_2[x] = (t << 8)  | (t >>> 24);
                SUB_MIX_3[x] = t;

                // Compute inv sub bytes, inv mix columns tables
                var t = (x8 * 0x1010101) ^ (x4 * 0x10001) ^ (x2 * 0x101) ^ (x * 0x1010100);
                INV_SUB_MIX_0[sx] = (t << 24) | (t >>> 8);
                INV_SUB_MIX_1[sx] = (t << 16) | (t >>> 16);
                INV_SUB_MIX_2[sx] = (t << 8)  | (t >>> 24);
                INV_SUB_MIX_3[sx] = t;

                // Compute next counter
                if (!x) {
                    x = xi = 1;
                } else {
                    x = x2 ^ d[d[d[x8 ^ x2]]];
                    xi ^= d[d[xi]];
                }
            }
        }());

        // Precomputed Rcon lookup
        var RCON = [0x00, 0x01, 0x02, 0x04, 0x08, 0x10, 0x20, 0x40, 0x80, 0x1b, 0x36];

        /**
         * AES block cipher algorithm.
         */
        var AES = C_algo.AES = BlockCipher.extend({
            _doReset: function () {
                // Skip reset of nRounds has been set before and key did not change
                if (this._nRounds && this._keyPriorReset === this._key) {
                    return;
                }

                // Shortcuts
                var key = this._keyPriorReset = this._key;
                var keyWords = key.words;
                var keySize = key.sigBytes / 4;

                // Compute number of rounds
                var nRounds = this._nRounds = keySize + 6;

                // Compute number of key schedule rows
                var ksRows = (nRounds + 1) * 4;

                // Compute key schedule
                var keySchedule = this._keySchedule = [];
                for (var ksRow = 0; ksRow < ksRows; ksRow++) {
                    if (ksRow < keySize) {
                        keySchedule[ksRow] = keyWords[ksRow];
                    } else {
                        var t = keySchedule[ksRow - 1];

                        if (!(ksRow % keySize)) {
                            // Rot word
                            t = (t << 8) | (t >>> 24);

                            // Sub word
                            t = (SBOX[t >>> 24] << 24) | (SBOX[(t >>> 16) & 0xff] << 16) | (SBOX[(t >>> 8) & 0xff] << 8) | SBOX[t & 0xff];

                            // Mix Rcon
                            t ^= RCON[(ksRow / keySize) | 0] << 24;
                        } else if (keySize > 6 && ksRow % keySize == 4) {
                            // Sub word
                            t = (SBOX[t >>> 24] << 24) | (SBOX[(t >>> 16) & 0xff] << 16) | (SBOX[(t >>> 8) & 0xff] << 8) | SBOX[t & 0xff];
                        }

                        keySchedule[ksRow] = keySchedule[ksRow - keySize] ^ t;
                    }
                }

                // Compute inv key schedule
                var invKeySchedule = this._invKeySchedule = [];
                for (var invKsRow = 0; invKsRow < ksRows; invKsRow++) {
                    var ksRow = ksRows - invKsRow;

                    if (invKsRow % 4) {
                        var t = keySchedule[ksRow];
                    } else {
                        var t = keySchedule[ksRow - 4];
                    }

                    if (invKsRow < 4 || ksRow <= 4) {
                        invKeySchedule[invKsRow] = t;
                    } else {
                        invKeySchedule[invKsRow] = INV_SUB_MIX_0[SBOX[t >>> 24]] ^ INV_SUB_MIX_1[SBOX[(t >>> 16) & 0xff]] ^
                            INV_SUB_MIX_2[SBOX[(t >>> 8) & 0xff]] ^ INV_SUB_MIX_3[SBOX[t & 0xff]];
                    }
                }
            },

            encryptBlock: function (M, offset) {
                this._doCryptBlock(M, offset, this._keySchedule, SUB_MIX_0, SUB_MIX_1, SUB_MIX_2, SUB_MIX_3, SBOX);
            },

            decryptBlock: function (M, offset) {
                // Swap 2nd and 4th rows
                var t = M[offset + 1];
                M[offset + 1] = M[offset + 3];
                M[offset + 3] = t;

                this._doCryptBlock(M, offset, this._invKeySchedule, INV_SUB_MIX_0, INV_SUB_MIX_1, INV_SUB_MIX_2, INV_SUB_MIX_3, INV_SBOX);

                // Inv swap 2nd and 4th rows
                var t = M[offset + 1];
                M[offset + 1] = M[offset + 3];
                M[offset + 3] = t;
            },

            _doCryptBlock: function (M, offset, keySchedule, SUB_MIX_0, SUB_MIX_1, SUB_MIX_2, SUB_MIX_3, SBOX) {
                // Shortcut
                var nRounds = this._nRounds;

                // Get input, add round key
                var s0 = M[offset]     ^ keySchedule[0];
                var s1 = M[offset + 1] ^ keySchedule[1];
                var s2 = M[offset + 2] ^ keySchedule[2];
                var s3 = M[offset + 3] ^ keySchedule[3];

                // Key schedule row counter
                var ksRow = 4;

                // Rounds
                for (var round = 1; round < nRounds; round++) {
                    // Shift rows, sub bytes, mix columns, add round key
                    var t0 = SUB_MIX_0[s0 >>> 24] ^ SUB_MIX_1[(s1 >>> 16) & 0xff] ^ SUB_MIX_2[(s2 >>> 8) & 0xff] ^ SUB_MIX_3[s3 & 0xff] ^ keySchedule[ksRow++];
                    var t1 = SUB_MIX_0[s1 >>> 24] ^ SUB_MIX_1[(s2 >>> 16) & 0xff] ^ SUB_MIX_2[(s3 >>> 8) & 0xff] ^ SUB_MIX_3[s0 & 0xff] ^ keySchedule[ksRow++];
                    var t2 = SUB_MIX_0[s2 >>> 24] ^ SUB_MIX_1[(s3 >>> 16) & 0xff] ^ SUB_MIX_2[(s0 >>> 8) & 0xff] ^ SUB_MIX_3[s1 & 0xff] ^ keySchedule[ksRow++];
                    var t3 = SUB_MIX_0[s3 >>> 24] ^ SUB_MIX_1[(s0 >>> 16) & 0xff] ^ SUB_MIX_2[(s1 >>> 8) & 0xff] ^ SUB_MIX_3[s2 & 0xff] ^ keySchedule[ksRow++];

                    // Update state
                    s0 = t0;
                    s1 = t1;
                    s2 = t2;
                    s3 = t3;
                }

                // Shift rows, sub bytes, add round key
                var t0 = ((SBOX[s0 >>> 24] << 24) | (SBOX[(s1 >>> 16) & 0xff] << 16) | (SBOX[(s2 >>> 8) & 0xff] << 8) | SBOX[s3 & 0xff]) ^ keySchedule[ksRow++];
                var t1 = ((SBOX[s1 >>> 24] << 24) | (SBOX[(s2 >>> 16) & 0xff] << 16) | (SBOX[(s3 >>> 8) & 0xff] << 8) | SBOX[s0 & 0xff]) ^ keySchedule[ksRow++];
                var t2 = ((SBOX[s2 >>> 24] << 24) | (SBOX[(s3 >>> 16) & 0xff] << 16) | (SBOX[(s0 >>> 8) & 0xff] << 8) | SBOX[s1 & 0xff]) ^ keySchedule[ksRow++];
                var t3 = ((SBOX[s3 >>> 24] << 24) | (SBOX[(s0 >>> 16) & 0xff] << 16) | (SBOX[(s1 >>> 8) & 0xff] << 8) | SBOX[s2 & 0xff]) ^ keySchedule[ksRow++];

                // Set output
                M[offset]     = t0;
                M[offset + 1] = t1;
                M[offset + 2] = t2;
                M[offset + 3] = t3;
            },

            keySize: 256/32
        });

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.AES.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.AES.decrypt(ciphertext, key, cfg);
         */
        C.AES = BlockCipher._createHelper(AES);
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var WordArray = C_lib.WordArray;
        var BlockCipher = C_lib.BlockCipher;
        var C_algo = C.algo;

        // Permuted Choice 1 constants
        var PC1 = [
            57, 49, 41, 33, 25, 17, 9,  1,
            58, 50, 42, 34, 26, 18, 10, 2,
            59, 51, 43, 35, 27, 19, 11, 3,
            60, 52, 44, 36, 63, 55, 47, 39,
            31, 23, 15, 7,  62, 54, 46, 38,
            30, 22, 14, 6,  61, 53, 45, 37,
            29, 21, 13, 5,  28, 20, 12, 4
        ];

        // Permuted Choice 2 constants
        var PC2 = [
            14, 17, 11, 24, 1,  5,
            3,  28, 15, 6,  21, 10,
            23, 19, 12, 4,  26, 8,
            16, 7,  27, 20, 13, 2,
            41, 52, 31, 37, 47, 55,
            30, 40, 51, 45, 33, 48,
            44, 49, 39, 56, 34, 53,
            46, 42, 50, 36, 29, 32
        ];

        // Cumulative bit shift constants
        var BIT_SHIFTS = [1,  2,  4,  6,  8,  10, 12, 14, 15, 17, 19, 21, 23, 25, 27, 28];

        // SBOXes and round permutation constants
        var SBOX_P = [
            {
                0x0: 0x808200,
                0x10000000: 0x8000,
                0x20000000: 0x808002,
                0x30000000: 0x2,
                0x40000000: 0x200,
                0x50000000: 0x808202,
                0x60000000: 0x800202,
                0x70000000: 0x800000,
                0x80000000: 0x202,
                0x90000000: 0x800200,
                0xa0000000: 0x8200,
                0xb0000000: 0x808000,
                0xc0000000: 0x8002,
                0xd0000000: 0x800002,
                0xe0000000: 0x0,
                0xf0000000: 0x8202,
                0x8000000: 0x0,
                0x18000000: 0x808202,
                0x28000000: 0x8202,
                0x38000000: 0x8000,
                0x48000000: 0x808200,
                0x58000000: 0x200,
                0x68000000: 0x808002,
                0x78000000: 0x2,
                0x88000000: 0x800200,
                0x98000000: 0x8200,
                0xa8000000: 0x808000,
                0xb8000000: 0x800202,
                0xc8000000: 0x800002,
                0xd8000000: 0x8002,
                0xe8000000: 0x202,
                0xf8000000: 0x800000,
                0x1: 0x8000,
                0x10000001: 0x2,
                0x20000001: 0x808200,
                0x30000001: 0x800000,
                0x40000001: 0x808002,
                0x50000001: 0x8200,
                0x60000001: 0x200,
                0x70000001: 0x800202,
                0x80000001: 0x808202,
                0x90000001: 0x808000,
                0xa0000001: 0x800002,
                0xb0000001: 0x8202,
                0xc0000001: 0x202,
                0xd0000001: 0x800200,
                0xe0000001: 0x8002,
                0xf0000001: 0x0,
                0x8000001: 0x808202,
                0x18000001: 0x808000,
                0x28000001: 0x800000,
                0x38000001: 0x200,
                0x48000001: 0x8000,
                0x58000001: 0x800002,
                0x68000001: 0x2,
                0x78000001: 0x8202,
                0x88000001: 0x8002,
                0x98000001: 0x800202,
                0xa8000001: 0x202,
                0xb8000001: 0x808200,
                0xc8000001: 0x800200,
                0xd8000001: 0x0,
                0xe8000001: 0x8200,
                0xf8000001: 0x808002
            },
            {
                0x0: 0x40084010,
                0x1000000: 0x4000,
                0x2000000: 0x80000,
                0x3000000: 0x40080010,
                0x4000000: 0x40000010,
                0x5000000: 0x40084000,
                0x6000000: 0x40004000,
                0x7000000: 0x10,
                0x8000000: 0x84000,
                0x9000000: 0x40004010,
                0xa000000: 0x40000000,
                0xb000000: 0x84010,
                0xc000000: 0x80010,
                0xd000000: 0x0,
                0xe000000: 0x4010,
                0xf000000: 0x40080000,
                0x800000: 0x40004000,
                0x1800000: 0x84010,
                0x2800000: 0x10,
                0x3800000: 0x40004010,
                0x4800000: 0x40084010,
                0x5800000: 0x40000000,
                0x6800000: 0x80000,
                0x7800000: 0x40080010,
                0x8800000: 0x80010,
                0x9800000: 0x0,
                0xa800000: 0x4000,
                0xb800000: 0x40080000,
                0xc800000: 0x40000010,
                0xd800000: 0x84000,
                0xe800000: 0x40084000,
                0xf800000: 0x4010,
                0x10000000: 0x0,
                0x11000000: 0x40080010,
                0x12000000: 0x40004010,
                0x13000000: 0x40084000,
                0x14000000: 0x40080000,
                0x15000000: 0x10,
                0x16000000: 0x84010,
                0x17000000: 0x4000,
                0x18000000: 0x4010,
                0x19000000: 0x80000,
                0x1a000000: 0x80010,
                0x1b000000: 0x40000010,
                0x1c000000: 0x84000,
                0x1d000000: 0x40004000,
                0x1e000000: 0x40000000,
                0x1f000000: 0x40084010,
                0x10800000: 0x84010,
                0x11800000: 0x80000,
                0x12800000: 0x40080000,
                0x13800000: 0x4000,
                0x14800000: 0x40004000,
                0x15800000: 0x40084010,
                0x16800000: 0x10,
                0x17800000: 0x40000000,
                0x18800000: 0x40084000,
                0x19800000: 0x40000010,
                0x1a800000: 0x40004010,
                0x1b800000: 0x80010,
                0x1c800000: 0x0,
                0x1d800000: 0x4010,
                0x1e800000: 0x40080010,
                0x1f800000: 0x84000
            },
            {
                0x0: 0x104,
                0x100000: 0x0,
                0x200000: 0x4000100,
                0x300000: 0x10104,
                0x400000: 0x10004,
                0x500000: 0x4000004,
                0x600000: 0x4010104,
                0x700000: 0x4010000,
                0x800000: 0x4000000,
                0x900000: 0x4010100,
                0xa00000: 0x10100,
                0xb00000: 0x4010004,
                0xc00000: 0x4000104,
                0xd00000: 0x10000,
                0xe00000: 0x4,
                0xf00000: 0x100,
                0x80000: 0x4010100,
                0x180000: 0x4010004,
                0x280000: 0x0,
                0x380000: 0x4000100,
                0x480000: 0x4000004,
                0x580000: 0x10000,
                0x680000: 0x10004,
                0x780000: 0x104,
                0x880000: 0x4,
                0x980000: 0x100,
                0xa80000: 0x4010000,
                0xb80000: 0x10104,
                0xc80000: 0x10100,
                0xd80000: 0x4000104,
                0xe80000: 0x4010104,
                0xf80000: 0x4000000,
                0x1000000: 0x4010100,
                0x1100000: 0x10004,
                0x1200000: 0x10000,
                0x1300000: 0x4000100,
                0x1400000: 0x100,
                0x1500000: 0x4010104,
                0x1600000: 0x4000004,
                0x1700000: 0x0,
                0x1800000: 0x4000104,
                0x1900000: 0x4000000,
                0x1a00000: 0x4,
                0x1b00000: 0x10100,
                0x1c00000: 0x4010000,
                0x1d00000: 0x104,
                0x1e00000: 0x10104,
                0x1f00000: 0x4010004,
                0x1080000: 0x4000000,
                0x1180000: 0x104,
                0x1280000: 0x4010100,
                0x1380000: 0x0,
                0x1480000: 0x10004,
                0x1580000: 0x4000100,
                0x1680000: 0x100,
                0x1780000: 0x4010004,
                0x1880000: 0x10000,
                0x1980000: 0x4010104,
                0x1a80000: 0x10104,
                0x1b80000: 0x4000004,
                0x1c80000: 0x4000104,
                0x1d80000: 0x4010000,
                0x1e80000: 0x4,
                0x1f80000: 0x10100
            },
            {
                0x0: 0x80401000,
                0x10000: 0x80001040,
                0x20000: 0x401040,
                0x30000: 0x80400000,
                0x40000: 0x0,
                0x50000: 0x401000,
                0x60000: 0x80000040,
                0x70000: 0x400040,
                0x80000: 0x80000000,
                0x90000: 0x400000,
                0xa0000: 0x40,
                0xb0000: 0x80001000,
                0xc0000: 0x80400040,
                0xd0000: 0x1040,
                0xe0000: 0x1000,
                0xf0000: 0x80401040,
                0x8000: 0x80001040,
                0x18000: 0x40,
                0x28000: 0x80400040,
                0x38000: 0x80001000,
                0x48000: 0x401000,
                0x58000: 0x80401040,
                0x68000: 0x0,
                0x78000: 0x80400000,
                0x88000: 0x1000,
                0x98000: 0x80401000,
                0xa8000: 0x400000,
                0xb8000: 0x1040,
                0xc8000: 0x80000000,
                0xd8000: 0x400040,
                0xe8000: 0x401040,
                0xf8000: 0x80000040,
                0x100000: 0x400040,
                0x110000: 0x401000,
                0x120000: 0x80000040,
                0x130000: 0x0,
                0x140000: 0x1040,
                0x150000: 0x80400040,
                0x160000: 0x80401000,
                0x170000: 0x80001040,
                0x180000: 0x80401040,
                0x190000: 0x80000000,
                0x1a0000: 0x80400000,
                0x1b0000: 0x401040,
                0x1c0000: 0x80001000,
                0x1d0000: 0x400000,
                0x1e0000: 0x40,
                0x1f0000: 0x1000,
                0x108000: 0x80400000,
                0x118000: 0x80401040,
                0x128000: 0x0,
                0x138000: 0x401000,
                0x148000: 0x400040,
                0x158000: 0x80000000,
                0x168000: 0x80001040,
                0x178000: 0x40,
                0x188000: 0x80000040,
                0x198000: 0x1000,
                0x1a8000: 0x80001000,
                0x1b8000: 0x80400040,
                0x1c8000: 0x1040,
                0x1d8000: 0x80401000,
                0x1e8000: 0x400000,
                0x1f8000: 0x401040
            },
            {
                0x0: 0x80,
                0x1000: 0x1040000,
                0x2000: 0x40000,
                0x3000: 0x20000000,
                0x4000: 0x20040080,
                0x5000: 0x1000080,
                0x6000: 0x21000080,
                0x7000: 0x40080,
                0x8000: 0x1000000,
                0x9000: 0x20040000,
                0xa000: 0x20000080,
                0xb000: 0x21040080,
                0xc000: 0x21040000,
                0xd000: 0x0,
                0xe000: 0x1040080,
                0xf000: 0x21000000,
                0x800: 0x1040080,
                0x1800: 0x21000080,
                0x2800: 0x80,
                0x3800: 0x1040000,
                0x4800: 0x40000,
                0x5800: 0x20040080,
                0x6800: 0x21040000,
                0x7800: 0x20000000,
                0x8800: 0x20040000,
                0x9800: 0x0,
                0xa800: 0x21040080,
                0xb800: 0x1000080,
                0xc800: 0x20000080,
                0xd800: 0x21000000,
                0xe800: 0x1000000,
                0xf800: 0x40080,
                0x10000: 0x40000,
                0x11000: 0x80,
                0x12000: 0x20000000,
                0x13000: 0x21000080,
                0x14000: 0x1000080,
                0x15000: 0x21040000,
                0x16000: 0x20040080,
                0x17000: 0x1000000,
                0x18000: 0x21040080,
                0x19000: 0x21000000,
                0x1a000: 0x1040000,
                0x1b000: 0x20040000,
                0x1c000: 0x40080,
                0x1d000: 0x20000080,
                0x1e000: 0x0,
                0x1f000: 0x1040080,
                0x10800: 0x21000080,
                0x11800: 0x1000000,
                0x12800: 0x1040000,
                0x13800: 0x20040080,
                0x14800: 0x20000000,
                0x15800: 0x1040080,
                0x16800: 0x80,
                0x17800: 0x21040000,
                0x18800: 0x40080,
                0x19800: 0x21040080,
                0x1a800: 0x0,
                0x1b800: 0x21000000,
                0x1c800: 0x1000080,
                0x1d800: 0x40000,
                0x1e800: 0x20040000,
                0x1f800: 0x20000080
            },
            {
                0x0: 0x10000008,
                0x100: 0x2000,
                0x200: 0x10200000,
                0x300: 0x10202008,
                0x400: 0x10002000,
                0x500: 0x200000,
                0x600: 0x200008,
                0x700: 0x10000000,
                0x800: 0x0,
                0x900: 0x10002008,
                0xa00: 0x202000,
                0xb00: 0x8,
                0xc00: 0x10200008,
                0xd00: 0x202008,
                0xe00: 0x2008,
                0xf00: 0x10202000,
                0x80: 0x10200000,
                0x180: 0x10202008,
                0x280: 0x8,
                0x380: 0x200000,
                0x480: 0x202008,
                0x580: 0x10000008,
                0x680: 0x10002000,
                0x780: 0x2008,
                0x880: 0x200008,
                0x980: 0x2000,
                0xa80: 0x10002008,
                0xb80: 0x10200008,
                0xc80: 0x0,
                0xd80: 0x10202000,
                0xe80: 0x202000,
                0xf80: 0x10000000,
                0x1000: 0x10002000,
                0x1100: 0x10200008,
                0x1200: 0x10202008,
                0x1300: 0x2008,
                0x1400: 0x200000,
                0x1500: 0x10000000,
                0x1600: 0x10000008,
                0x1700: 0x202000,
                0x1800: 0x202008,
                0x1900: 0x0,
                0x1a00: 0x8,
                0x1b00: 0x10200000,
                0x1c00: 0x2000,
                0x1d00: 0x10002008,
                0x1e00: 0x10202000,
                0x1f00: 0x200008,
                0x1080: 0x8,
                0x1180: 0x202000,
                0x1280: 0x200000,
                0x1380: 0x10000008,
                0x1480: 0x10002000,
                0x1580: 0x2008,
                0x1680: 0x10202008,
                0x1780: 0x10200000,
                0x1880: 0x10202000,
                0x1980: 0x10200008,
                0x1a80: 0x2000,
                0x1b80: 0x202008,
                0x1c80: 0x200008,
                0x1d80: 0x0,
                0x1e80: 0x10000000,
                0x1f80: 0x10002008
            },
            {
                0x0: 0x100000,
                0x10: 0x2000401,
                0x20: 0x400,
                0x30: 0x100401,
                0x40: 0x2100401,
                0x50: 0x0,
                0x60: 0x1,
                0x70: 0x2100001,
                0x80: 0x2000400,
                0x90: 0x100001,
                0xa0: 0x2000001,
                0xb0: 0x2100400,
                0xc0: 0x2100000,
                0xd0: 0x401,
                0xe0: 0x100400,
                0xf0: 0x2000000,
                0x8: 0x2100001,
                0x18: 0x0,
                0x28: 0x2000401,
                0x38: 0x2100400,
                0x48: 0x100000,
                0x58: 0x2000001,
                0x68: 0x2000000,
                0x78: 0x401,
                0x88: 0x100401,
                0x98: 0x2000400,
                0xa8: 0x2100000,
                0xb8: 0x100001,
                0xc8: 0x400,
                0xd8: 0x2100401,
                0xe8: 0x1,
                0xf8: 0x100400,
                0x100: 0x2000000,
                0x110: 0x100000,
                0x120: 0x2000401,
                0x130: 0x2100001,
                0x140: 0x100001,
                0x150: 0x2000400,
                0x160: 0x2100400,
                0x170: 0x100401,
                0x180: 0x401,
                0x190: 0x2100401,
                0x1a0: 0x100400,
                0x1b0: 0x1,
                0x1c0: 0x0,
                0x1d0: 0x2100000,
                0x1e0: 0x2000001,
                0x1f0: 0x400,
                0x108: 0x100400,
                0x118: 0x2000401,
                0x128: 0x2100001,
                0x138: 0x1,
                0x148: 0x2000000,
                0x158: 0x100000,
                0x168: 0x401,
                0x178: 0x2100400,
                0x188: 0x2000001,
                0x198: 0x2100000,
                0x1a8: 0x0,
                0x1b8: 0x2100401,
                0x1c8: 0x100401,
                0x1d8: 0x400,
                0x1e8: 0x2000400,
                0x1f8: 0x100001
            },
            {
                0x0: 0x8000820,
                0x1: 0x20000,
                0x2: 0x8000000,
                0x3: 0x20,
                0x4: 0x20020,
                0x5: 0x8020820,
                0x6: 0x8020800,
                0x7: 0x800,
                0x8: 0x8020000,
                0x9: 0x8000800,
                0xa: 0x20800,
                0xb: 0x8020020,
                0xc: 0x820,
                0xd: 0x0,
                0xe: 0x8000020,
                0xf: 0x20820,
                0x80000000: 0x800,
                0x80000001: 0x8020820,
                0x80000002: 0x8000820,
                0x80000003: 0x8000000,
                0x80000004: 0x8020000,
                0x80000005: 0x20800,
                0x80000006: 0x20820,
                0x80000007: 0x20,
                0x80000008: 0x8000020,
                0x80000009: 0x820,
                0x8000000a: 0x20020,
                0x8000000b: 0x8020800,
                0x8000000c: 0x0,
                0x8000000d: 0x8020020,
                0x8000000e: 0x8000800,
                0x8000000f: 0x20000,
                0x10: 0x20820,
                0x11: 0x8020800,
                0x12: 0x20,
                0x13: 0x800,
                0x14: 0x8000800,
                0x15: 0x8000020,
                0x16: 0x8020020,
                0x17: 0x20000,
                0x18: 0x0,
                0x19: 0x20020,
                0x1a: 0x8020000,
                0x1b: 0x8000820,
                0x1c: 0x8020820,
                0x1d: 0x20800,
                0x1e: 0x820,
                0x1f: 0x8000000,
                0x80000010: 0x20000,
                0x80000011: 0x800,
                0x80000012: 0x8020020,
                0x80000013: 0x20820,
                0x80000014: 0x20,
                0x80000015: 0x8020000,
                0x80000016: 0x8000000,
                0x80000017: 0x8000820,
                0x80000018: 0x8020820,
                0x80000019: 0x8000020,
                0x8000001a: 0x8000800,
                0x8000001b: 0x0,
                0x8000001c: 0x20800,
                0x8000001d: 0x820,
                0x8000001e: 0x20020,
                0x8000001f: 0x8020800
            }
        ];

        // Masks that select the SBOX input
        var SBOX_MASK = [
            0xf8000001, 0x1f800000, 0x01f80000, 0x001f8000,
            0x0001f800, 0x00001f80, 0x000001f8, 0x8000001f
        ];

        /**
         * DES block cipher algorithm.
         */
        var DES = C_algo.DES = BlockCipher.extend({
            _doReset: function () {
                // Shortcuts
                var key = this._key;
                var keyWords = key.words;

                // Select 56 bits according to PC1
                var keyBits = [];
                for (var i = 0; i < 56; i++) {
                    var keyBitPos = PC1[i] - 1;
                    keyBits[i] = (keyWords[keyBitPos >>> 5] >>> (31 - keyBitPos % 32)) & 1;
                }

                // Assemble 16 subkeys
                var subKeys = this._subKeys = [];
                for (var nSubKey = 0; nSubKey < 16; nSubKey++) {
                    // Create subkey
                    var subKey = subKeys[nSubKey] = [];

                    // Shortcut
                    var bitShift = BIT_SHIFTS[nSubKey];

                    // Select 48 bits according to PC2
                    for (var i = 0; i < 24; i++) {
                        // Select from the left 28 key bits
                        subKey[(i / 6) | 0] |= keyBits[((PC2[i] - 1) + bitShift) % 28] << (31 - i % 6);

                        // Select from the right 28 key bits
                        subKey[4 + ((i / 6) | 0)] |= keyBits[28 + (((PC2[i + 24] - 1) + bitShift) % 28)] << (31 - i % 6);
                    }

                    // Since each subkey is applied to an expanded 32-bit input,
                    // the subkey can be broken into 8 values scaled to 32-bits,
                    // which allows the key to be used without expansion
                    subKey[0] = (subKey[0] << 1) | (subKey[0] >>> 31);
                    for (var i = 1; i < 7; i++) {
                        subKey[i] = subKey[i] >>> ((i - 1) * 4 + 3);
                    }
                    subKey[7] = (subKey[7] << 5) | (subKey[7] >>> 27);
                }

                // Compute inverse subkeys
                var invSubKeys = this._invSubKeys = [];
                for (var i = 0; i < 16; i++) {
                    invSubKeys[i] = subKeys[15 - i];
                }
            },

            encryptBlock: function (M, offset) {
                this._doCryptBlock(M, offset, this._subKeys);
            },

            decryptBlock: function (M, offset) {
                this._doCryptBlock(M, offset, this._invSubKeys);
            },

            _doCryptBlock: function (M, offset, subKeys) {
                // Get input
                this._lBlock = M[offset];
                this._rBlock = M[offset + 1];

                // Initial permutation
                exchangeLR.call(this, 4,  0x0f0f0f0f);
                exchangeLR.call(this, 16, 0x0000ffff);
                exchangeRL.call(this, 2,  0x33333333);
                exchangeRL.call(this, 8,  0x00ff00ff);
                exchangeLR.call(this, 1,  0x55555555);

                // Rounds
                for (var round = 0; round < 16; round++) {
                    // Shortcuts
                    var subKey = subKeys[round];
                    var lBlock = this._lBlock;
                    var rBlock = this._rBlock;

                    // Feistel function
                    var f = 0;
                    for (var i = 0; i < 8; i++) {
                        f |= SBOX_P[i][((rBlock ^ subKey[i]) & SBOX_MASK[i]) >>> 0];
                    }
                    this._lBlock = rBlock;
                    this._rBlock = lBlock ^ f;
                }

                // Undo swap from last round
                var t = this._lBlock;
                this._lBlock = this._rBlock;
                this._rBlock = t;

                // Final permutation
                exchangeLR.call(this, 1,  0x55555555);
                exchangeRL.call(this, 8,  0x00ff00ff);
                exchangeRL.call(this, 2,  0x33333333);
                exchangeLR.call(this, 16, 0x0000ffff);
                exchangeLR.call(this, 4,  0x0f0f0f0f);

                // Set output
                M[offset] = this._lBlock;
                M[offset + 1] = this._rBlock;
            },

            keySize: 64/32,

            ivSize: 64/32,

            blockSize: 64/32
        });

        // Swap bits across the left and right words
        function exchangeLR(offset, mask) {
            var t = ((this._lBlock >>> offset) ^ this._rBlock) & mask;
            this._rBlock ^= t;
            this._lBlock ^= t << offset;
        }

        function exchangeRL(offset, mask) {
            var t = ((this._rBlock >>> offset) ^ this._lBlock) & mask;
            this._lBlock ^= t;
            this._rBlock ^= t << offset;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.DES.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.DES.decrypt(ciphertext, key, cfg);
         */
        C.DES = BlockCipher._createHelper(DES);

        /**
         * Triple-DES block cipher algorithm.
         */
        var TripleDES = C_algo.TripleDES = BlockCipher.extend({
            _doReset: function () {
                // Shortcuts
                var key = this._key;
                var keyWords = key.words;

                // Create DES instances
                this._des1 = DES.createEncryptor(WordArray.create(keyWords.slice(0, 2)));
                this._des2 = DES.createEncryptor(WordArray.create(keyWords.slice(2, 4)));
                this._des3 = DES.createEncryptor(WordArray.create(keyWords.slice(4, 6)));
            },

            encryptBlock: function (M, offset) {
                this._des1.encryptBlock(M, offset);
                this._des2.decryptBlock(M, offset);
                this._des3.encryptBlock(M, offset);
            },

            decryptBlock: function (M, offset) {
                this._des3.decryptBlock(M, offset);
                this._des2.encryptBlock(M, offset);
                this._des1.decryptBlock(M, offset);
            },

            keySize: 192/32,

            ivSize: 64/32,

            blockSize: 64/32
        });

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.TripleDES.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.TripleDES.decrypt(ciphertext, key, cfg);
         */
        C.TripleDES = BlockCipher._createHelper(TripleDES);
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var StreamCipher = C_lib.StreamCipher;
        var C_algo = C.algo;

        /**
         * RC4 stream cipher algorithm.
         */
        var RC4 = C_algo.RC4 = StreamCipher.extend({
            _doReset: function () {
                // Shortcuts
                var key = this._key;
                var keyWords = key.words;
                var keySigBytes = key.sigBytes;

                // Init sbox
                var S = this._S = [];
                for (var i = 0; i < 256; i++) {
                    S[i] = i;
                }

                // Key setup
                for (var i = 0, j = 0; i < 256; i++) {
                    var keyByteIndex = i % keySigBytes;
                    var keyByte = (keyWords[keyByteIndex >>> 2] >>> (24 - (keyByteIndex % 4) * 8)) & 0xff;

                    j = (j + S[i] + keyByte) % 256;

                    // Swap
                    var t = S[i];
                    S[i] = S[j];
                    S[j] = t;
                }

                // Counters
                this._i = this._j = 0;
            },

            _doProcessBlock: function (M, offset) {
                M[offset] ^= generateKeystreamWord.call(this);
            },

            keySize: 256/32,

            ivSize: 0
        });

        function generateKeystreamWord() {
            // Shortcuts
            var S = this._S;
            var i = this._i;
            var j = this._j;

            // Generate keystream word
            var keystreamWord = 0;
            for (var n = 0; n < 4; n++) {
                i = (i + 1) % 256;
                j = (j + S[i]) % 256;

                // Swap
                var t = S[i];
                S[i] = S[j];
                S[j] = t;

                keystreamWord |= S[(S[i] + S[j]) % 256] << (24 - n * 8);
            }

            // Update counters
            this._i = i;
            this._j = j;

            return keystreamWord;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.RC4.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.RC4.decrypt(ciphertext, key, cfg);
         */
        C.RC4 = StreamCipher._createHelper(RC4);

        /**
         * Modified RC4 stream cipher algorithm.
         */
        var RC4Drop = C_algo.RC4Drop = RC4.extend({
            /**
             * Configuration options.
             *
             * @property {number} drop The number of keystream words to drop. Default 192
             */
            cfg: RC4.cfg.extend({
                drop: 192
            }),

            _doReset: function () {
                RC4._doReset.call(this);

                // Drop
                for (var i = this.cfg.drop; i > 0; i--) {
                    generateKeystreamWord.call(this);
                }
            }
        });

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.RC4Drop.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.RC4Drop.decrypt(ciphertext, key, cfg);
         */
        C.RC4Drop = StreamCipher._createHelper(RC4Drop);
    }());


    /** @preserve
     * Counter block mode compatible with  Dr Brian Gladman fileenc.c
     * derived from CryptoJS.mode.CTR
     * Jan Hruby jhruby.web@gmail.com
     */
    CryptoJS.mode.CTRGladman = (function () {
        var CTRGladman = CryptoJS.lib.BlockCipherMode.extend();

        function incWord(word)
        {
            if (((word >> 24) & 0xff) === 0xff) { //overflow
                var b1 = (word >> 16)&0xff;
                var b2 = (word >> 8)&0xff;
                var b3 = word & 0xff;

                if (b1 === 0xff) // overflow b1
                {
                    b1 = 0;
                    if (b2 === 0xff)
                    {
                        b2 = 0;
                        if (b3 === 0xff)
                        {
                            b3 = 0;
                        }
                        else
                        {
                            ++b3;
                        }
                    }
                    else
                    {
                        ++b2;
                    }
                }
                else
                {
                    ++b1;
                }

                word = 0;
                word += (b1 << 16);
                word += (b2 << 8);
                word += b3;
            }
            else
            {
                word += (0x01 << 24);
            }
            return word;
        }

        function incCounter(counter)
        {
            if ((counter[0] = incWord(counter[0])) === 0)
            {
                // encr_data in fileenc.c from  Dr Brian Gladman's counts only with DWORD j < 8
                counter[1] = incWord(counter[1]);
            }
            return counter;
        }

        var Encryptor = CTRGladman.Encryptor = CTRGladman.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher
                var blockSize = cipher.blockSize;
                var iv = this._iv;
                var counter = this._counter;

                // Generate keystream
                if (iv) {
                    counter = this._counter = iv.slice(0);

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                }

                incCounter(counter);

                var keystream = counter.slice(0);
                cipher.encryptBlock(keystream, 0);

                // Encrypt
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= keystream[i];
                }
            }
        });

        CTRGladman.Decryptor = Encryptor;

        return CTRGladman;
    }());




    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var StreamCipher = C_lib.StreamCipher;
        var C_algo = C.algo;

        // Reusable objects
        var S  = [];
        var C_ = [];
        var G  = [];

        /**
         * Rabbit stream cipher algorithm
         */
        var Rabbit = C_algo.Rabbit = StreamCipher.extend({
            _doReset: function () {
                // Shortcuts
                var K = this._key.words;
                var iv = this.cfg.iv;

                // Swap endian
                for (var i = 0; i < 4; i++) {
                    K[i] = (((K[i] << 8)  | (K[i] >>> 24)) & 0x00ff00ff) |
                        (((K[i] << 24) | (K[i] >>> 8))  & 0xff00ff00);
                }

                // Generate initial state values
                var X = this._X = [
                    K[0], (K[3] << 16) | (K[2] >>> 16),
                    K[1], (K[0] << 16) | (K[3] >>> 16),
                    K[2], (K[1] << 16) | (K[0] >>> 16),
                    K[3], (K[2] << 16) | (K[1] >>> 16)
                ];

                // Generate initial counter values
                var C = this._C = [
                    (K[2] << 16) | (K[2] >>> 16), (K[0] & 0xffff0000) | (K[1] & 0x0000ffff),
                    (K[3] << 16) | (K[3] >>> 16), (K[1] & 0xffff0000) | (K[2] & 0x0000ffff),
                    (K[0] << 16) | (K[0] >>> 16), (K[2] & 0xffff0000) | (K[3] & 0x0000ffff),
                    (K[1] << 16) | (K[1] >>> 16), (K[3] & 0xffff0000) | (K[0] & 0x0000ffff)
                ];

                // Carry bit
                this._b = 0;

                // Iterate the system four times
                for (var i = 0; i < 4; i++) {
                    nextState.call(this);
                }

                // Modify the counters
                for (var i = 0; i < 8; i++) {
                    C[i] ^= X[(i + 4) & 7];
                }

                // IV setup
                if (iv) {
                    // Shortcuts
                    var IV = iv.words;
                    var IV_0 = IV[0];
                    var IV_1 = IV[1];

                    // Generate four subvectors
                    var i0 = (((IV_0 << 8) | (IV_0 >>> 24)) & 0x00ff00ff) | (((IV_0 << 24) | (IV_0 >>> 8)) & 0xff00ff00);
                    var i2 = (((IV_1 << 8) | (IV_1 >>> 24)) & 0x00ff00ff) | (((IV_1 << 24) | (IV_1 >>> 8)) & 0xff00ff00);
                    var i1 = (i0 >>> 16) | (i2 & 0xffff0000);
                    var i3 = (i2 << 16)  | (i0 & 0x0000ffff);

                    // Modify counter values
                    C[0] ^= i0;
                    C[1] ^= i1;
                    C[2] ^= i2;
                    C[3] ^= i3;
                    C[4] ^= i0;
                    C[5] ^= i1;
                    C[6] ^= i2;
                    C[7] ^= i3;

                    // Iterate the system four times
                    for (var i = 0; i < 4; i++) {
                        nextState.call(this);
                    }
                }
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var X = this._X;

                // Iterate the system
                nextState.call(this);

                // Generate four keystream words
                S[0] = X[0] ^ (X[5] >>> 16) ^ (X[3] << 16);
                S[1] = X[2] ^ (X[7] >>> 16) ^ (X[5] << 16);
                S[2] = X[4] ^ (X[1] >>> 16) ^ (X[7] << 16);
                S[3] = X[6] ^ (X[3] >>> 16) ^ (X[1] << 16);

                for (var i = 0; i < 4; i++) {
                    // Swap endian
                    S[i] = (((S[i] << 8)  | (S[i] >>> 24)) & 0x00ff00ff) |
                        (((S[i] << 24) | (S[i] >>> 8))  & 0xff00ff00);

                    // Encrypt
                    M[offset + i] ^= S[i];
                }
            },

            blockSize: 128/32,

            ivSize: 64/32
        });

        function nextState() {
            // Shortcuts
            var X = this._X;
            var C = this._C;

            // Save old counter values
            for (var i = 0; i < 8; i++) {
                C_[i] = C[i];
            }

            // Calculate new counter values
            C[0] = (C[0] + 0x4d34d34d + this._b) | 0;
            C[1] = (C[1] + 0xd34d34d3 + ((C[0] >>> 0) < (C_[0] >>> 0) ? 1 : 0)) | 0;
            C[2] = (C[2] + 0x34d34d34 + ((C[1] >>> 0) < (C_[1] >>> 0) ? 1 : 0)) | 0;
            C[3] = (C[3] + 0x4d34d34d + ((C[2] >>> 0) < (C_[2] >>> 0) ? 1 : 0)) | 0;
            C[4] = (C[4] + 0xd34d34d3 + ((C[3] >>> 0) < (C_[3] >>> 0) ? 1 : 0)) | 0;
            C[5] = (C[5] + 0x34d34d34 + ((C[4] >>> 0) < (C_[4] >>> 0) ? 1 : 0)) | 0;
            C[6] = (C[6] + 0x4d34d34d + ((C[5] >>> 0) < (C_[5] >>> 0) ? 1 : 0)) | 0;
            C[7] = (C[7] + 0xd34d34d3 + ((C[6] >>> 0) < (C_[6] >>> 0) ? 1 : 0)) | 0;
            this._b = (C[7] >>> 0) < (C_[7] >>> 0) ? 1 : 0;

            // Calculate the g-values
            for (var i = 0; i < 8; i++) {
                var gx = X[i] + C[i];

                // Construct high and low argument for squaring
                var ga = gx & 0xffff;
                var gb = gx >>> 16;

                // Calculate high and low result of squaring
                var gh = ((((ga * ga) >>> 17) + ga * gb) >>> 15) + gb * gb;
                var gl = (((gx & 0xffff0000) * gx) | 0) + (((gx & 0x0000ffff) * gx) | 0);

                // High XOR low
                G[i] = gh ^ gl;
            }

            // Calculate new state values
            X[0] = (G[0] + ((G[7] << 16) | (G[7] >>> 16)) + ((G[6] << 16) | (G[6] >>> 16))) | 0;
            X[1] = (G[1] + ((G[0] << 8)  | (G[0] >>> 24)) + G[7]) | 0;
            X[2] = (G[2] + ((G[1] << 16) | (G[1] >>> 16)) + ((G[0] << 16) | (G[0] >>> 16))) | 0;
            X[3] = (G[3] + ((G[2] << 8)  | (G[2] >>> 24)) + G[1]) | 0;
            X[4] = (G[4] + ((G[3] << 16) | (G[3] >>> 16)) + ((G[2] << 16) | (G[2] >>> 16))) | 0;
            X[5] = (G[5] + ((G[4] << 8)  | (G[4] >>> 24)) + G[3]) | 0;
            X[6] = (G[6] + ((G[5] << 16) | (G[5] >>> 16)) + ((G[4] << 16) | (G[4] >>> 16))) | 0;
            X[7] = (G[7] + ((G[6] << 8)  | (G[6] >>> 24)) + G[5]) | 0;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.Rabbit.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.Rabbit.decrypt(ciphertext, key, cfg);
         */
        C.Rabbit = StreamCipher._createHelper(Rabbit);
    }());


    /**
     * Counter block mode.
     */
    CryptoJS.mode.CTR = (function () {
        var CTR = CryptoJS.lib.BlockCipherMode.extend();

        var Encryptor = CTR.Encryptor = CTR.extend({
            processBlock: function (words, offset) {
                // Shortcuts
                var cipher = this._cipher
                var blockSize = cipher.blockSize;
                var iv = this._iv;
                var counter = this._counter;

                // Generate keystream
                if (iv) {
                    counter = this._counter = iv.slice(0);

                    // Remove IV for subsequent blocks
                    this._iv = undefined;
                }
                var keystream = counter.slice(0);
                cipher.encryptBlock(keystream, 0);

                // Increment counter
                counter[blockSize - 1] = (counter[blockSize - 1] + 1) | 0

                // Encrypt
                for (var i = 0; i < blockSize; i++) {
                    words[offset + i] ^= keystream[i];
                }
            }
        });

        CTR.Decryptor = Encryptor;

        return CTR;
    }());


    (function () {
        // Shortcuts
        var C = CryptoJS;
        var C_lib = C.lib;
        var StreamCipher = C_lib.StreamCipher;
        var C_algo = C.algo;

        // Reusable objects
        var S  = [];
        var C_ = [];
        var G  = [];

        /**
         * Rabbit stream cipher algorithm.
         *
         * This is a legacy version that neglected to convert the key to little-endian.
         * This error doesn't affect the cipher's security,
         * but it does affect its compatibility with other implementations.
         */
        var RabbitLegacy = C_algo.RabbitLegacy = StreamCipher.extend({
            _doReset: function () {
                // Shortcuts
                var K = this._key.words;
                var iv = this.cfg.iv;

                // Generate initial state values
                var X = this._X = [
                    K[0], (K[3] << 16) | (K[2] >>> 16),
                    K[1], (K[0] << 16) | (K[3] >>> 16),
                    K[2], (K[1] << 16) | (K[0] >>> 16),
                    K[3], (K[2] << 16) | (K[1] >>> 16)
                ];

                // Generate initial counter values
                var C = this._C = [
                    (K[2] << 16) | (K[2] >>> 16), (K[0] & 0xffff0000) | (K[1] & 0x0000ffff),
                    (K[3] << 16) | (K[3] >>> 16), (K[1] & 0xffff0000) | (K[2] & 0x0000ffff),
                    (K[0] << 16) | (K[0] >>> 16), (K[2] & 0xffff0000) | (K[3] & 0x0000ffff),
                    (K[1] << 16) | (K[1] >>> 16), (K[3] & 0xffff0000) | (K[0] & 0x0000ffff)
                ];

                // Carry bit
                this._b = 0;

                // Iterate the system four times
                for (var i = 0; i < 4; i++) {
                    nextState.call(this);
                }

                // Modify the counters
                for (var i = 0; i < 8; i++) {
                    C[i] ^= X[(i + 4) & 7];
                }

                // IV setup
                if (iv) {
                    // Shortcuts
                    var IV = iv.words;
                    var IV_0 = IV[0];
                    var IV_1 = IV[1];

                    // Generate four subvectors
                    var i0 = (((IV_0 << 8) | (IV_0 >>> 24)) & 0x00ff00ff) | (((IV_0 << 24) | (IV_0 >>> 8)) & 0xff00ff00);
                    var i2 = (((IV_1 << 8) | (IV_1 >>> 24)) & 0x00ff00ff) | (((IV_1 << 24) | (IV_1 >>> 8)) & 0xff00ff00);
                    var i1 = (i0 >>> 16) | (i2 & 0xffff0000);
                    var i3 = (i2 << 16)  | (i0 & 0x0000ffff);

                    // Modify counter values
                    C[0] ^= i0;
                    C[1] ^= i1;
                    C[2] ^= i2;
                    C[3] ^= i3;
                    C[4] ^= i0;
                    C[5] ^= i1;
                    C[6] ^= i2;
                    C[7] ^= i3;

                    // Iterate the system four times
                    for (var i = 0; i < 4; i++) {
                        nextState.call(this);
                    }
                }
            },

            _doProcessBlock: function (M, offset) {
                // Shortcut
                var X = this._X;

                // Iterate the system
                nextState.call(this);

                // Generate four keystream words
                S[0] = X[0] ^ (X[5] >>> 16) ^ (X[3] << 16);
                S[1] = X[2] ^ (X[7] >>> 16) ^ (X[5] << 16);
                S[2] = X[4] ^ (X[1] >>> 16) ^ (X[7] << 16);
                S[3] = X[6] ^ (X[3] >>> 16) ^ (X[1] << 16);

                for (var i = 0; i < 4; i++) {
                    // Swap endian
                    S[i] = (((S[i] << 8)  | (S[i] >>> 24)) & 0x00ff00ff) |
                        (((S[i] << 24) | (S[i] >>> 8))  & 0xff00ff00);

                    // Encrypt
                    M[offset + i] ^= S[i];
                }
            },

            blockSize: 128/32,

            ivSize: 64/32
        });

        function nextState() {
            // Shortcuts
            var X = this._X;
            var C = this._C;

            // Save old counter values
            for (var i = 0; i < 8; i++) {
                C_[i] = C[i];
            }

            // Calculate new counter values
            C[0] = (C[0] + 0x4d34d34d + this._b) | 0;
            C[1] = (C[1] + 0xd34d34d3 + ((C[0] >>> 0) < (C_[0] >>> 0) ? 1 : 0)) | 0;
            C[2] = (C[2] + 0x34d34d34 + ((C[1] >>> 0) < (C_[1] >>> 0) ? 1 : 0)) | 0;
            C[3] = (C[3] + 0x4d34d34d + ((C[2] >>> 0) < (C_[2] >>> 0) ? 1 : 0)) | 0;
            C[4] = (C[4] + 0xd34d34d3 + ((C[3] >>> 0) < (C_[3] >>> 0) ? 1 : 0)) | 0;
            C[5] = (C[5] + 0x34d34d34 + ((C[4] >>> 0) < (C_[4] >>> 0) ? 1 : 0)) | 0;
            C[6] = (C[6] + 0x4d34d34d + ((C[5] >>> 0) < (C_[5] >>> 0) ? 1 : 0)) | 0;
            C[7] = (C[7] + 0xd34d34d3 + ((C[6] >>> 0) < (C_[6] >>> 0) ? 1 : 0)) | 0;
            this._b = (C[7] >>> 0) < (C_[7] >>> 0) ? 1 : 0;

            // Calculate the g-values
            for (var i = 0; i < 8; i++) {
                var gx = X[i] + C[i];

                // Construct high and low argument for squaring
                var ga = gx & 0xffff;
                var gb = gx >>> 16;

                // Calculate high and low result of squaring
                var gh = ((((ga * ga) >>> 17) + ga * gb) >>> 15) + gb * gb;
                var gl = (((gx & 0xffff0000) * gx) | 0) + (((gx & 0x0000ffff) * gx) | 0);

                // High XOR low
                G[i] = gh ^ gl;
            }

            // Calculate new state values
            X[0] = (G[0] + ((G[7] << 16) | (G[7] >>> 16)) + ((G[6] << 16) | (G[6] >>> 16))) | 0;
            X[1] = (G[1] + ((G[0] << 8)  | (G[0] >>> 24)) + G[7]) | 0;
            X[2] = (G[2] + ((G[1] << 16) | (G[1] >>> 16)) + ((G[0] << 16) | (G[0] >>> 16))) | 0;
            X[3] = (G[3] + ((G[2] << 8)  | (G[2] >>> 24)) + G[1]) | 0;
            X[4] = (G[4] + ((G[3] << 16) | (G[3] >>> 16)) + ((G[2] << 16) | (G[2] >>> 16))) | 0;
            X[5] = (G[5] + ((G[4] << 8)  | (G[4] >>> 24)) + G[3]) | 0;
            X[6] = (G[6] + ((G[5] << 16) | (G[5] >>> 16)) + ((G[4] << 16) | (G[4] >>> 16))) | 0;
            X[7] = (G[7] + ((G[6] << 8)  | (G[6] >>> 24)) + G[5]) | 0;
        }

        /**
         * Shortcut functions to the cipher's object interface.
         *
         * @example
         *
         *     var ciphertext = CryptoJS.RabbitLegacy.encrypt(message, key, cfg);
         *     var plaintext  = CryptoJS.RabbitLegacy.decrypt(ciphertext, key, cfg);
         */
        C.RabbitLegacy = StreamCipher._createHelper(RabbitLegacy);
    }());


    /**
     * Zero padding strategy.
     */
    CryptoJS.pad.ZeroPadding = {
        pad: function (data, blockSize) {
            // Shortcut
            var blockSizeBytes = blockSize * 4;

            // Pad
            data.clamp();
            data.sigBytes += blockSizeBytes - ((data.sigBytes % blockSizeBytes) || blockSizeBytes);
        },

        unpad: function (data) {
            // Shortcut
            var dataWords = data.words;

            // Unpad
            var i = data.sigBytes - 1;
            while (!((dataWords[i >>> 2] >>> (24 - (i % 4) * 8)) & 0xff)) {
                i--;
            }
            data.sigBytes = i + 1;
        }
    };


    return CryptoJS;

}));</script>

<script>
    // variables to be filled when generating the file
    var encryptedMsg = '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',
        salt = '906e782eac72ba0d497b2f78bf1f770a',
        isRememberEnabled = true,
        rememberDurationInDays = 0; // 0 means forever

    // constants
    var rememberPassphraseKey = 'staticrypt_passphrase',
        rememberExpirationKey = 'staticrypt_expiration';

    /**
     * Decrypt a salted msg using a password.
     * Inspired by https://github.com/adonespitogo
     *
     * @param  encryptedMsg
     * @param  hashedPassphrase
     * @returns 
     */
    function decryptMsg(encryptedMsg, hashedPassphrase) {
        var iv = CryptoJS.enc.Hex.parse(encryptedMsg.substr(0, 32))
        var encrypted = encryptedMsg.substring(32);

        return CryptoJS.AES.decrypt(encrypted, hashedPassphrase, {
            iv: iv,
            padding: CryptoJS.pad.Pkcs7,
            mode: CryptoJS.mode.CBC
        }).toString(CryptoJS.enc.Utf8);
    }

    /**
     * Decrypt our encrypted page, replace the whole HTML.
     *
     * @param  hashedPassphrase
     * @returns 
     */
    function decryptAndReplaceHtml(hashedPassphrase) {
        var encryptedHMAC = encryptedMsg.substring(0, 64),
            encryptedHTML = encryptedMsg.substring(64),
            decryptedHMAC = CryptoJS.HmacSHA256(encryptedHTML, CryptoJS.SHA256(hashedPassphrase).toString()).toString();

        if (decryptedHMAC !== encryptedHMAC) {
            return false;
        }

        var plainHTML = decryptMsg(encryptedHTML, hashedPassphrase);

        document.write(plainHTML);
        document.close();

        return true;
    }

    /**
     * Salt and hash the passphrase so it can be stored in localStorage without opening a password reuse vulnerability.
     *
     * @param  passphrase
     * @returns 
     */
    function hashPassphrase(passphrase) {
        return CryptoJS.PBKDF2(passphrase, salt, {
            keySize: 256 / 32,
            iterations: 1000
        }).toString();
    }

    /**
     * Clear localstorage from staticrypt related values
     */
    function clearLocalStorage() {
        localStorage.removeItem(rememberPassphraseKey);
        localStorage.removeItem(rememberExpirationKey);
    }

    // try to automatically decrypt on load if there is a saved password
    window.onload = function () {
        if (isRememberEnabled) {
            // show the remember me checkbox
            document.getElementById('staticrypt-remember-label').classList.remove('hidden');

            // if we are login out, clear the storage and terminate
            var queryParams = new URLSearchParams(window.location.search);

            if (queryParams.has("staticrypt_logout")) {
                return clearLocalStorage();
            }

            // if there is expiration configured, check if we're not beyond the expiration
            if (rememberDurationInDays && rememberDurationInDays > 0) {
                var expiration = localStorage.getItem(rememberExpirationKey),
                    isExpired = expiration && new Date().getTime() > parseInt(expiration);

                if (isExpired) {
                    return clearLocalStorage();
                }
            }

            var hashedPassphrase = localStorage.getItem(rememberPassphraseKey);

            if (hashedPassphrase) {
                // try to decrypt
                var isDecryptionSuccessful = decryptAndReplaceHtml(hashedPassphrase);

                // if the decryption is unsuccessful the password might be wrong - silently clear the saved data and let
                // the user fill the password form again
                if (!isDecryptionSuccessful) {
                    return clearLocalStorage();
                }
            }
        }
    }

    // handle password form submission
    document.getElementById('staticrypt-form').addEventListener('submit', function (e) {
        e.preventDefault();

        var passphrase = document.getElementById('staticrypt-password').value,
            shouldRememberPassphrase = document.getElementById('staticrypt-remember').checked;

        // decrypt and replace the whole page
        var hashedPassphrase = hashPassphrase(passphrase);
        var isDecryptionSuccessful = decryptAndReplaceHtml(hashedPassphrase);

        if (isDecryptionSuccessful) {
            // remember the hashedPassphrase and set its expiration if necessary
            if (isRememberEnabled && shouldRememberPassphrase) {
                window.localStorage.setItem(rememberPassphraseKey, hashedPassphrase);

                // set the expiration if the duration isn't 0 (meaning no expiration)
                if (rememberDurationInDays > 0) {
                    window.localStorage.setItem(
                        rememberExpirationKey,
                        (new Date().getTime() + rememberDurationInDays * 24 * 60 * 60 * 1000).toString()
                    );
                }
            }
        } else {
            alert('Bad passphrase!');
        }
    });
</script>
</body>
</html>

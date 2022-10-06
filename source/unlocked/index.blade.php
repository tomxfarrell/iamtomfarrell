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
        salt = '619cfc36964d11f52c42ee77ba35393d',
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
